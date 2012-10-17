<?php

class LocalUsersBindContactProcessor extends modProcessor
{
	public function process() {
		
		/* format data */
		$userid = substr(strrchr($this->getProperty('user'),'_'),1);
		$customerid = substr(strrchr($this->getProperty('contact'),'_'),1);
		$customername = $this->getProperty('contactname');
		if (empty($userid) || empty($customerid) || empty($customername)) { return $this->modx->error->failure($this->modx->lexicon('moneybird.error.invalid_data')); }
		
		// remove any customer relations which could be set (otherwise a contact is nog being moved on sort, but added twice)
		$this->modx->removeCollection('mbRelation', array('customerid' => $customerid));
		
		/* whatever user already haves a contact */
		$exists = $this->modx->getObject('mbRelation', array('user' => $userid, 'customerid' => $customerid));
		if (!empty($exists) && is_object($exists)) { return $this->modx->error->failure($this->modx->lexicon('moneybird.error.user_ahr')); }
		
		$relation = $this->modx->newObject('mbRelation');
		$relation->fromArray(array(
			'user' => $userid,
			'customerid' => $customerid,
			'customername' => $customername,
			'createdon' => time(),
			'createdby' => $this->modx->user->get('id'),
		));
		$relation->save();
		
		return $this->success();
	}
}

return 'LocalUsersBindContactProcessor';

?>