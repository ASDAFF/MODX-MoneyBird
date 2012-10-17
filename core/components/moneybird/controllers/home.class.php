<?php

class MoneyBirdHomeManagerController extends MoneyBirdManagerController {
    public function process(array $scriptProperties = array()) {
		
    }
    public function getPageTitle() { return $this->modx->lexicon('moneybird'); }
    public function loadCustomCssJs() {
        $this->addJavascript($this->moneybird->config['jsUrl'].'mgr/widgets/users.tree.js');
        $this->addJavascript($this->moneybird->config['jsUrl'].'mgr/widgets/mbcontacts.tree.js');
        $this->addJavascript($this->moneybird->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->moneybird->config['jsUrl'].'mgr/sections/index.js');
    }
    public function getTemplateFile() { return $this->moneybird->config['templatesPath'].'home.tpl'; }
}

?>