<?php

require_once dirname(__FILE__).'/build.config.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$sources = array(
    'model' => MODX_CORE_PATH.'components/moneybird/model/',
    'schema_file' => MODX_CORE_PATH.'components/moneybird/model/schema/moneybird.mysql.schema.xml',
);
$manager= $modx->getManager();
$generator= $manager->getGenerator();

if (!is_dir($sources['model'])) { $modx->log(modX::LOG_LEVEL_ERROR,'Model directory not found!'); die(); }
if (!file_exists($sources['schema_file'])) { $modx->log(modX::LOG_LEVEL_ERROR,'Schema file not found!'); die(); }

$generator->parseSchema($sources['schema_file'],$sources['model']);
$modx->log(modX::LOG_LEVEL_INFO, 'Done parsing schema file...');

$modx->addPackage('moneybird', $sources['model']);
$manager->createObjectContainer('mbRelation');

$modx->log(modX::LOG_LEVEL_INFO, 'Done creating object containers...');

?>