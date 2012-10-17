<?php

$modx =& $object->xpdo;
$success= false;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $settings = array(
			'account_name' => 'Auth',
			'auth_username' => 'Auth',
			'auth_password' => 'Auth',
		);
		foreach($settings as $key => $area) {
			$setting = $modx->getObject('modSystemSetting', array('key' => 'moneybird.'.$key));
			if(empty($setting) || !is_object($setting)) {
				$setting = $modx->newObject('modSystemSetting');
				$setting->set('key', 'moneybird.'.$key);
			}
			if(isset($options[$key])) {
				$setting->set('value', $options[$key]);
			}
			$setting->set('namespace', 'moneybird'); // to be sure
			$setting->set('area', $area); // to be sure
			$setting->save();
		}
		
        $success= true;
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        $success= true;
        break;
}
return $success;

?>