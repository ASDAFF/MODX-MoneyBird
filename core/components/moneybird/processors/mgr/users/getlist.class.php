<?php

class LocalUsersGetListProcessor extends modProcessor
{
	/** The reference of the service **/
	var $service;
	
	public function initialize() {
		$this->service = $this->modx->moneybird->api->getService('Contact');
		return true;
	}
	
	public function process() {
		
		/* get parent */
        $id = $this->getProperty('id');
        $id = empty($id) ? 0 : str_replace('n_lu_','',$id);
		
		$list = array();
        if (empty($id)) {
			$users = $this->modx->getCollection('modUser');
			foreach($users as $user) {
				$list[] = array(
					'text' => $user->get('username').' ('.$user->get('id').')',
					'id' => 'n_lu_'.$user->get('id'),
					'leaf' => false,
					'type' => 'modUser',
					'cls' => 'icon-user',
					'data' => $user->toArray(),
				);
			}
		}
		else {
			$c = $this->modx->newQuery('mbRelation');
			$c->where(array('user' => $id));
			$c->sortby('customername ASC, id', 'ASC');
			$relations = $this->modx->getCollection('mbRelation', $c);
			if (!empty($relations)) {
				
				foreach($relations as $relation) {
					
					$data = $this->modx->cacheManager->get('contacts/'.$relation->get('customerid'), $this->modx->moneybird->config['cacheOptions']);
					if(!empty($data)) {
						$displayName = $data['companyName'];
						$contactName = $data['contactName'];
						if(!empty($displayName) && !empty($contactName)) { $displayName .= ' ('.$data['contactName'].')'; }
						if(empty($displayName)) { $displayName = $data['name']; }
						$city = $contact->city;
						if(!empty($city)) { $displayName .= ', '.$city; }
						
						$list[] = array(
							'text' => $displayName,
							'id' => 'n_lumbc_'.$id.'_'.$relation->get('customerid'),
							'leaf' => true,
							'type' => 'MoneyBirdContact',
							'cls' => 'none',
							'iconCls' => 'icon-vcard',
							'data' => $data,
						);
					}
				}
			}
		}
		
		return $this->toJSON($list);
	}
}
return 'LocalUsersGetListProcessor';

?>