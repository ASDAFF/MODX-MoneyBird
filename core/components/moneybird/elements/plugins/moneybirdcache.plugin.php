<?php
/**
 * MoneyBirdCache
 * Plugin to clear the cache created for MoneyBird component
 * 
 * @package moneybird
 * @subpackage plugins
 * @author Bert Oost at OostDesign.nl <bert@oostdesign.nl>
 */
$mb = $modx->getService('moneybird', 'MoneyBird', $modx->getOption('moneybird.core_path', null, $modx->getOption('core_path').'components/moneybird/').'model/moneybird/', $scriptProperties);
if (!($mb instanceof MoneyBird)) return '';

$eventName = $modx->event->name;
switch($eventName) {
    case 'OnSiteRefresh':
        $modx->getCacheManager();
        $modx->cacheManager->refresh(array(
            'moneybird/invoices' => array()
        ));
        $modx->log(modX::LOG_LEVEL_WARN, '[MoneyBird] components cache is cleared!'); flush();
    break;
}

?>