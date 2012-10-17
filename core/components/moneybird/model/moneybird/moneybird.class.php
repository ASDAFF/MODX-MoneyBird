<?php
/**
 * The main MoneyBird class
 *
 * @package moneybird
 * @author Bert Oost at OostDesign.nl <bert@oostdesign.nl>
 */

class MoneyBird
{
	public $modx;
	public $config = array();
	
	/** Reference to the MoneyBird API connector **/
	public $api;
	
	public function __construct(modX &$modx,array $config = array()) {
		$this->modx =& $modx;
 
		$basePath = $this->modx->getOption('moneybird.core_path',$config,$this->modx->getOption('core_path').'components/moneybird/');
		$assetsUrl = $this->modx->getOption('moneybird.assets_url',$config,$this->modx->getOption('assets_url').'components/moneybird/');
		$this->config = array_merge(array(
			'basePath' => $basePath,
			'corePath' => $basePath,
			'modelPath' => $basePath.'model/',
			'processorsPath' => $basePath.'processors/',
			'templatesPath' => $basePath.'templates/',
			'chunksPath' => $basePath.'elements/chunks/',
			'jsUrl' => $assetsUrl.'js/',
			'cssUrl' => $assetsUrl.'css/',
			'assetsUrl' => $assetsUrl,
			'connectorUrl' => $assetsUrl.'connector.php',
			'cacheOptions' => array(xPDO::OPT_CACHE_KEY => 'moneybird'),
		),$config);
		$this->modx->addPackage('moneybird', $this->config['modelPath']);
		
		// autoloader for MoneyBird API stuff
		require_once($this->config['modelPath'].'api/ApiConnector.php');
		spl_autoload_register('Moneybird\ApiConnector::autoload');
		
		try {
			
			$accountname = $this->modx->getOption('moneybird.account_name', $config, '');
			$username = $this->modx->getOption('moneybird.auth_username', $config, '');
			$password = $this->modx->getOption('moneybird.auth_password', $config, '');
			
			if (empty($accountname) || empty($username) || empty($password)) {
				$this->modx->log(modX::LOG_LEVEL_ERROR, '[MoneyBird] Account name, username and/or password to connect with MoneyBird are empty!');
			}
			
			// setup the transport and connector
			$transport = new Moneybird\HttpClient();
			$transport->setAuth($username, $password);
			$this->api = new Moneybird\ApiConnector($accountname,$transport, new Moneybird\XmlMapper());
			
			// some errors?
			$errors = $this->api->getErrors();
			if (!empty($errors)) {
				foreach ($errors as $error) {
					$this->modx->log(modX::LOG_LEVEL_ERROR, '[MoneyBird] '.$error->attribute.': '.$error->message);
				}
			}
		}
		catch (Exception $e) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[MoneyBird] '.$e->getMessage());
		}
	}
	
	public function getChunk($name,$properties = array()) {
		$chunk = null;
		if (!isset($this->chunks[$name])) {
			$chunk = $this->_getTplChunk($name);
			if (empty($chunk)) {
				$chunk = $this->modx->getObject('modChunk',array('name' => $name));
				if ($chunk == false) return false;
			}
			$this->chunks[$name] = $chunk->getContent();
		} else {
			$o = $this->chunks[$name];
			$chunk = $this->modx->newObject('modChunk');
			$chunk->setContent($o);
		}
		$chunk->setCacheable(false);
		return $chunk->process($properties);
	}
	
	private function _getTplChunk($name,$postfix = '.chunk.tpl') {
		$chunk = false;
		$f = $this->config['chunksPath'].strtolower($name).$postfix;
		if (file_exists($f)) {
			$o = file_get_contents($f);
			$chunk = $this->modx->newObject('modChunk');
			$chunk->set('name',$name);
			$chunk->setContent($o);
		}
		return $chunk;
	}
	
	public function mapCurrency($currency='EUR') {
		$symbol = $currency;
		$map = array(
			'&#8364;' => array('EUR'), // Euro
			'&#36;' => array('USD','NZD','SGD','HKD','CAD','AUD','MXN'), // Dollar (and Mexican peso?)
			'&#114;' => array('DKK','NOK','SEK'), // Danish/Norway/Swedish Krone
			'&#1083;' => array('BGN'), // Bulgarian lev
			'&#82;' => array('BRL'), // Brazilian real
			'&#67;' => array('CHF'), // Swiss franc
			'&#165;' => array('CNY'), // Chinese renminb
			'&#269;' => array('CZK'), // Czech koruna
			'&#163;' => array('GBP'), // British pound
			'&#110;' => array('HRK'), // Croatian kuna
			'&#70;' => array('HUF'), // Hungarian forint
			'&#112;' => array('IDR'), // Indonesian rupiah
			'&#8362;' => array('ILS'), // Israeli new sheqel
			'&#8360;' => array('INR'), // Indian rupee
			'&#165;' => array('JPY'), // Japanese yen
			'&#8361;' => array('KPW','KRW'), // North/South Korean won
			'&#76;' => array('LTL'), // Lithuanian litas
			'&#115;' => array('LVL'), // Latvian lats
			'&#77;' => array('MYR'), // Malaysian ringgit
			'&#8369;' => array('PHP'), // Philippine peso
			'&#122;' => array('PLN'), // Polish zloty
			'&#108;' => array('RON'), // Romanian leu
			'&#1088;' => array('RUB'), // Russian ruble
			'&#3647;' => array('THB'), // Thai baht
			'TRL' => array('TRY','TRL'), // Turkish new lira (no symbol?)
			'ZAR' => array('ZAR'), // South African rand (no symbol?)
		);
		
		foreach($map as $s => $currencies) {
			if(in_array($currency, $currencies)) {
				$symbol = $s;
				break;
			}
		}
		return $symbol;
	}
}

?>