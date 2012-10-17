<?php

if ($object->xpdo) {
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
			$modx =& $object->xpdo;
			$modelPath = $modx->getOption('moneybird.core_path',null,$modx->getOption('core_path').'components/moneybird/').'model/';
			$modx->addPackage('moneybird',$modelPath);
			
			$manager = $modx->getManager();
			
			$modx->setLogLevel(modX::LOG_LEVEL_ERROR); // to hide the create table queries from the console
			$manager->createObjectContainer('mbRelation');
			$modx->setLogLevel(modX::LOG_LEVEL_INFO); // for the next things back to info level
		break;
		
		case xPDOTransport::ACTION_UPGRADE:
		break;
	}
}
return true;

?>