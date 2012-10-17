<?php

$settings = array();

$settings['moneybird.account_name']= $modx->newObject('modSystemSetting');
$settings['moneybird.account_name']->fromArray(array(
    'key' => 'moneybird.account_name',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'moneybird',
    'area' => 'Auth',
),'',true,true);

$settings['moneybird.auth_username']= $modx->newObject('modSystemSetting');
$settings['moneybird.auth_username']->fromArray(array(
    'key' => 'moneybird.auth_username',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'moneybird',
    'area' => 'Auth',
),'',true,true);

$settings['moneybird.auth_password']= $modx->newObject('modSystemSetting');
$settings['moneybird.auth_password']->fromArray(array(
    'key' => 'moneybird.auth_password',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'moneybird',
    'area' => 'Auth',
),'',true,true);

return $settings;

?>