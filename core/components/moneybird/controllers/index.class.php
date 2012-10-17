<?php
/**
 * The index controller
 *
 * @package moneybird
 */

require_once dirname(dirname(__FILE__)) . '/model/moneybird/moneybird.class.php';
abstract class MoneyBirdManagerController extends modExtraManagerController {
    /** @var MoneyBird $moneybird */
    public $moneybird;
    public function initialize() {
        $this->moneybird = new MoneyBird($this->modx);
		
        $this->addCss($this->moneybird->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->moneybird->config['jsUrl'].'mgr/moneybird.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            MoneyBird.config = '.$this->modx->toJSON($this->moneybird->config).';
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('moneybird:default');
    }
    public function checkPermissions() { return true;}
}
class ControllersIndexManagerController extends MoneyBirdManagerController {
    public static function getDefaultController() { return 'home'; }
}

?>