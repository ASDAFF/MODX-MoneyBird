<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';
 
$corePath = $modx->getOption('moneybird.core_path',null,$modx->getOption('core_path').'components/moneybird/');
require_once $corePath.'model/moneybird/moneybird.class.php';
$modx->moneybird = new MoneyBird($modx);
 
$modx->lexicon->load('moneybird:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->moneybird->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));

?>