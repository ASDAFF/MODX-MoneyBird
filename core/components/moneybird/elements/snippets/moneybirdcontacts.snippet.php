<?php
/**
 * MoneyBirdContacts
 *
 * Lists all contacts binded to the user 
 *
 * @package moneybird
 * @author Bert Oost at OostDesign.nl <bert@oostdesign.nl>
 *
 * TEMPLATING:
 *  tpl - (Req.) The template chunk for each single contact entry
 *  outerTpl - (Opt.) The outer template for all contact entries in the list (Use [[+wrapper]])
 *  toPlaceholder - (Opt.) A placeholder name to set with the output instead of returning it
 *  outputSeparator - (Opt.) How to separate the content from the next. Default to newline ("\n")
 *
 * GETPAGE COMPATIBLE
 *  limit - (Opt.) To limit the results. Only applied when greater then 0.
 *  offset - (Opt.) From where to start with the listing.
 *  totalVar - (Opt.) The placeholder name of the placeholder containing the absolute total. Default set to "total".
 *
 * OTHER:
 *  filterKey - (Opt.) The name of the key to bind the filter on. Default set to "mbc".
 *  invoicesResource - (Opt.) The ID of the resource where the "MoneyBirdInvoices" snippet is on. Default set to itself.
 *  showNone - (Opt.) Used whether to show a "none" option in the filter list. Default set to true.
 *
 * CACHING OPTIONS
 *  cacheExpire - (Opt.) The time when the cache is expired and rebuild. Default set to 86400 (24 hours). Smallest is 900 (15 minutes)
 */
$mb = $modx->getService('moneybird','MoneyBird',$modx->getOption('moneybird.core_path',null,$modx->getOption('core_path').'components/moneybird/').'model/moneybird/',$scriptProperties);
if (!($mb instanceof MoneyBird)) return '';

$user =& $modx->user;
if(!$user->hasSessionContext($modx->context->get('key'))) {
    $modx->sendUnauthorizedPage();
}
$userId = $user->get('id');
$modx->lexicon->load('moneybird:default');

// properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'mbContact');
$outerTpl = $modx->getOption('outerTpl', $scriptProperties, 'mbContacts');
$filterKey = $modx->getOption('filterKey', $scriptProperties, 'mbc');
$isFiltered = (isset($_GET[$filterKey]) && !empty($_GET[$filterKey])) ? $_GET[$filterKey] : false;
$invoicesResource = $modx->getOption('invoicesResource', $scriptProperties, $modx->resource->get('id'));
$showNone = (boolean) $modx->getOption('showNone', $scriptProperties, 1);

// output stuff
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, '');
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
$output = '';

// getPage compatibility
$limit = $modx->getOption('limit', $scriptProperties, 0);
$offset = $modx->getOption('offset', $scriptProperties, 0);
$totalVar = $modx->getOption('totalVar', $scriptProperties, 'total');

// cache options
$cacheExpire = $modx->getOption('cacheExpire', $scriptProperties, 86400); // default 24 hours
if(empty($cacheExpire) || $cacheExpire < 900) { $cacheExpire = 900; }
$cacheOptions = $modx->moneybird->config['cacheOptions'];

// get contacts
$contacts = $modx->cacheManager->get('contacts/usr-'.$userId.'/summary', $cacheOptions);
if(empty($contacts)) {
    
    // get all related contacts
    $c = $modx->newQuery('mbRelation');
    $c->where(array('user' => $userId));
    if($isFiltered !== false) {
        $c->andCondition(array(
            'customerid' => $isFiltered
        ));
    }
    $c->sortby('customername ASC, id', 'ASC');
    
    $relations = $modx->getCollection('mbRelation', $c);
    
    // iterate them all
    $contacts = array();
    foreach($relations as $relation) {
        $contacts[] = $relation->get('customerid');
    }
    
    if(!empty($contacts)) {
        
        // save invoices list
        $modx->cacheManager->set('contacts/usr-'.$userId.'/summary', $contacts, $cacheExpire, $cacheOptions);
    }
}

// set total for getPage compatible
$total = count($contacts);
$modx->setPlaceholder($totalVar, $total);

// if it is limitated...
if(!empty($limit)) {
    $contacts = array_slice($contacts, $offset, $limit);
}

// list up all invoices
foreach($contacts as $idx => $customerId) {
    $phs = $modx->cacheManager->get('contacts/'.$customerId, $cacheOptions);
    if(empty($phs)) { continue; }
    
    // build displayName
    $displayName = $phs['companyName'];
	$contactName = $phs['contactName'];
	if(!empty($displayName) && !empty($contactName)) { $displayName .= ' ('.$phs['contactName'].')'; }
	if(empty($displayName)) { $displayName = $phs['name']; }
	$city = $phs['city'];
	if(!empty($city)) { $displayName .= ', '.$city; }
    
    $phs['displayName'] = $displayName;
    $phs['idx'] = ($idx + 1);
    $phs['selected'] = (($isFiltered !== false && $isFiltered == $phs['customerId']) ? '1' : '0');
    
    $output .= $modx->moneybird->getChunk($tpl, $phs).$outputSeparator;
}

if(!empty($outerTpl) && !empty($output)) {
    $output = $modx->moneybird->getChunk($outerTpl, array(
        'total' => $total,
        'showNone' => (($showNone === true) ? '1' : '0'),
        'filterKey' => $filterKey,
        'invoicesResource' => $invoicesResource,
        'wrapper' => $output,
    ));
}

if(!empty($toPlacholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}

return $output;

?>