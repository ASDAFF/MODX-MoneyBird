<?php
/**
 * MoneyBirdInvoices
 *
 * Lists the invoices based on the binded contacts 
 *
 * @package moneybird
 * @author Bert Oost at OostDesign.nl <bert@oostdesign.nl>
 *
 * TEMPLATING:
 *  tpl - (Req.) The template chunk for each single invoice entry
 *  outerTpl - (Opt.) The outer template for all invoice entries in the list (Use [[+wrapper]])
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

// get contacts service
$contactService = $modx->moneybird->api->getService('Contact');
$invoiceService = $modx->moneybird->api->getService('Invoice');

// properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'mbInvoice');
$outerTpl = $modx->getOption('outerTpl', $scriptProperties, 'mbInvoices');
$filterKey = $modx->getOption('filterKey', $scriptProperties, 'mbc');
$isFiltered = (isset($_GET[$filterKey]) && !empty($_GET[$filterKey])) ? $_GET[$filterKey] : false;

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

// figure out if there is a contact filter active
$summaryKey = 'invoices/usr-'.$userId.'/summary';
if($isFiltered !== false) {
    $summaryKey = 'invoices/usr-'.$userId.'/'.$isFiltered.'/summary';
}

// get invoices
$invoices = $modx->cacheManager->get($summaryKey, $cacheOptions);
if(empty($invoices)) {
    
    // get all related contacts
    $c = $modx->newQuery('mbRelation');
    $c->where(array('user' => $user->get('id')));
    if($isFiltered !== false) {
        $c->andCondition(array(
            'customerid' => $isFiltered
        ));
    }
    $c->sortby('customername ASC, id','ASC');
    
    $relations = $modx->getCollection('mbRelation', $c);
    
    // iterate them all
    $invoices = array();
    foreach($relations as $relation) {
        $customerId = $relation->get('customerid');
        
        $list = array();
        $contact = $contactService->getByCustomerId($customerId);
        $all = $contact->getInvoices($invoiceService, 'all');
        foreach($all as $entry) {
            $list[] = $entry->invoiceId;
            $dataArray = array(
                'id' => $entry->id,
                'invoiceId' => $entry->invoiceId,
                'dueDateInterval' => $entry->dueDateInterval,
                'discount' => $entry->discount,
                'totalPaid' => $entry->totalPaid,
                'totalPriceExclTax' => $entry->totalPriceExclTax,
                'totalPriceInclTax' => $entry->totalPriceInclTax,
                'totalTax' => $entry->totalTax,
                'totalUnpaid' => $entry->totalUnpaid,
                'currency' => $entry->currency,
                'state' => $entry->state,
                'daysOpen' => $entry->daysOpen,
                'url' => $entry->url,
                'payUrl' => $entry->payUrl,
                'pdfUrl' => $entry->pdfUrl,
                'sendMethod' => $entry->sendMethod,
                'invoiceDate' => (is_object($entry->invoiceDate)) ? $entry->invoiceDate->format('Y-m-d') : null,
                'createdAt' => (is_object($entry->createdAt)) ? $entry->createdAt->format('Y-m-d H:i:s') : null,
                'updatedAt' => (is_object($entry->updatedAt)) ? $entry->updatedAt->format('Y-m-d H:i:s') : null,
            );
            
            $modx->cacheManager->set('invoices/usr-'.$userId.'/'.$entry->invoiceId, $dataArray, $cacheExpire, $cacheOptions);
        }
        
        // sort invoices reversed
        rsort($list);
        
        // set customer-based listing cache
        $modx->cacheManager->set('invoices/usr-'.$userId.'/'.$customerId.'/summary', $list, $cacheExpire, $cacheOptions);
        
        // merge into overall list
        $invoices = array_merge($invoices, $list);
    }
    
    if(!empty($invoices)) {
        
        // sort invoices reversed
        rsort($invoices);
        
        // save invoices list
        $modx->cacheManager->set('invoices/usr-'.$userId.'/summary', $invoices, $cacheExpire, $cacheOptions);
    }
}

// set total for getPage compatible
$total = count($invoices);
$modx->setPlaceholder($totalVar, $total);

// if it is limitated...
if(!empty($limit)) {
    $invoices = array_slice($invoices, $offset, $limit);
}

// list up all invoices
foreach($invoices as $idx => $invoiceId) {
    $phs = $modx->cacheManager->get('invoices/usr-'.$userId.'/'.$invoiceId, $cacheOptions);
    if(empty($phs)) { continue; }
    
    $phs['idx'] = ($idx + 1);
    $phs['currencySymbol'] = $modx->moneybird->mapCurrency($phs['currency']);
    
    $output .= $modx->moneybird->getChunk($tpl, $phs).$outputSeparator;
}

if(!empty($outerTpl) && !empty($output)) {
    $output = $modx->moneybird->getChunk($outerTpl, array(
        'total' => $total,
        'filterKey' => $filterKey,
        'wrapper' => $output,
    ));
}

if(!empty($toPlacholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}

return $output;

?>