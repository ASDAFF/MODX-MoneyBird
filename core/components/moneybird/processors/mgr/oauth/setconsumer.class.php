<?php

class SetConsumerProcessor extends modProcessor
{
	/**
	 * Will process the file and returns back a success or failure for the manager page
	 * @return json
	 */
	public function process() {
		$accountname = $this->getProperty('accountname');
		if(!isset($accountname) || empty($accountname)) {
			return $this->failure($this->modx->lexicon('moneybird.consumer.set.error.name_ns'));
		}
		$consumerkey = $this->getProperty('consumerkey');
		if(!isset($consumerkey) || empty($consumerkey)) {
			return $this->failure($this->modx->lexicon('moneybird.consumer.set.error.key_ns'));
		}
		$consumersecret = $this->getProperty('consumersecret');
		if(!isset($consumersecret) || empty($consumersecret)) {
			return $this->failure($this->modx->lexicon('moneybird.consumer.set.error.secret_ns'));
		}
		
		// accountname setting
		$setting = $this->modx->getObject('modSystemSetting', array('key' => 'moneybird.account_name'));
		if(empty($setting)) {
			$setting = $this->modx->newObject('modSystemSetting');
			$setting->fromArray(array(
				'key' => 'moneybird.account_name',
				'xtype' => 'textfield',
				'namespace' => 'moneybird',
				'area' => 'manager'
			),'',true);
		}
		$setting->set('value', $accountname);
		$setting->save();
		
		// consumerkey setting
		$setting = $this->modx->getObject('modSystemSetting', array('key' => 'moneybird.consumer_key'));
		if(empty($setting)) {
			$setting = $this->modx->newObject('modSystemSetting');
			$setting->fromArray(array(
				'key' => 'moneybird.consumer_key',
				'xtype' => 'textfield',
				'namespace' => 'moneybird',
				'area' => 'manager'
			),'',true);
		}
		$setting->set('value', $consumerkey);
		$setting->save();
		
		// consumersecret setting
		$setting = $this->modx->getObject('modSystemSetting', array('key' => 'moneybird.consumer_secret'));
		if(empty($setting)) {
			$setting = $this->modx->newObject('modSystemSetting');
			$setting->fromArray(array(
				'key' => 'moneybird.consumer_secret',
				'xtype' => 'textfield',
				'namespace' => 'moneybird',
				'area' => 'manager'
			),'',true);
		}
		$setting->set('value', $consumersecret);
		$setting->save();
		
		if(!$this->oauthRequestToken()) {
			
			return $this->failure('request token failed');
		}
		
		return $this->success('', array('accountname' => $accountname, 'consumerkey' => $consumerkey, 'consumersecret' => $consumersecret));
	}
	
	private function oauthRequestToken() {
		$accountname = $this->getProperty('accountname');
		$consumerkey = $this->getProperty('consumerkey');
		$consumersecret = $this->getProperty('consumersecret');
		
		// setup request
		$request = Moneybird\Lib\OAuthRequest::from_request('POST', 'http://'.$accountname.'.moneybird.nl/oauth/request_token', 'oath_consumer_key='.$consumerkey.'&oath_consumer_secret='.$consumersecret);
		var_dump($request); exit();
		return false;
	}
}

return 'SetConsumerProcessor';

?>