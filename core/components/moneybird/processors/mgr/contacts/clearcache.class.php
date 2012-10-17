<?php

class MoneyBirdContactsClearCacheProcessor extends modProcessor
{
	public function process() {
		$this->modx->cacheManager->refresh(array(
			'moneybird' => array()
		));
		return $this->success();
	}
}

return 'MoneyBirdContactsClearCacheProcessor';

?>