<?php
/**
 * Build the setup options form.
 *
 * @package moneybird
 * @subpackage build
 */
/* set some default values */
$values = array(
    'account_name' => '',
    'auth_username' => '',
    'auth_password' => '',
);
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $setting = $modx->getObject('modSystemSetting',array('key' => 'moneybird.account_name'));
        if ($setting != null) { $values['account_name'] = $setting->get('value'); }
        unset($setting);

        $setting = $modx->getObject('modSystemSetting',array('key' => 'moneybird.auth_username'));
        if ($setting != null) { $values['auth_username'] = $setting->get('value'); }
        unset($setting);

        $setting = $modx->getObject('modSystemSetting',array('key' => 'moneybird.auth_password'));
        if ($setting != null) { $values['auth_password'] = $setting->get('value'); }
        unset($setting);
    break;
    case xPDOTransport::ACTION_UNINSTALL: break;
}

$output = '<label for="moneybird-account_name">Your MoneyBird Account Name:</label>
<input type="text" name="account_name" id="moneybird-account_name" width="300" value="'.$values['account_name'].'" />
<br /><br />

<label for="moneybird-auth_username">MoneyBird Username:</label>
<input type="text" name="auth_username" id="moneybird-auth_username" width="300" value="'.$values['auth_username'].'" />
<br /><br />

<label for="moneybird-auth_password">MoneyBird Password:</label>
<input type="text" name="auth_password" id="moneybird-auth_password" width="300" value="'.$values['auth_password'].'" />';

return $output;

?>