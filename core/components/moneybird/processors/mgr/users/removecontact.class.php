<?php

class LocalUsersRemoveContactProcessor extends modProcessor
{
	public function process() {
		
		/* format data */
		$customerid = $this->getProperty('customer');
		$userid = $this->getProperty('user');
		if (empty($customerid) || empty($userid)) { return $this->modx->error->failure($this->modx->lexicon('moneybird.error.invalid_data')); }
		
		/* whatever user already haves a contact */
		$relation = $this->modx->getObject('mbRelation', array('user' => $userid, 'customerid' => $customerid));
		if (empty($relation) || !is_object($relation)) { return $this->modx->error->failure($this->modx->lexicon('moneybird.error.relation_ne')); }
		
		$relation->remove();
		
		return $this->success();
	}
}

return 'LocalUsersRemoveContactProcessor';

?>