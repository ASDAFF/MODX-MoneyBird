<?php

class MoneyBirdContactsGetListProcessor extends modProcessor
{
	/** The reference of the service **/
	var $service;
	
	public function initialize() {
		$this->service = $this->modx->moneybird->api->getService('Contact');
		return true;
	}
	
	public function process() {
		
        $id = $this->getProperty('id');
        $id = empty($id) ? 0 : str_replace('n_mbc_','',$id);
		
		$list = array();
		if(empty($id)) {
			
			$list = $this->modx->cacheManager->get('contacts/summary', $this->modx->moneybird->config['cacheOptions']);
			if(empty($list)) {
				
				$contacts = $this->service->getAll();
				foreach ($contacts as $contact) {
					$displayName = $contact->companyName;
					
					$contactName = $contact->contactName;
					if(!empty($displayName) && !empty($contactName)) {
						$displayName .= ' ('.$contact->contactName.')';
					}
					if(empty($displayName)) {
						$displayName = $contact->name;
					}
					
					$city = $contact->city;
					if(!empty($city)) {
						$displayName .= ', '.$city;
					}
					
					$data = array(
						'text' => $displayName,
						'id' => 'n_mbc_'.$contact->customerId,
						'leaf' => false,
						'type' => 'MoneyBirdContact',
						'cls' => 'none',
						'iconCls' => 'icon-vcard',
						'data' => array(
							'customerId' => $contact->customerId,
							'contactHash' => $contact->contactHash,
							'companyName' => $contact->companyName,
							'contactName' => $contact->contactName,
							'attention' => $contact->attention,
							'name' => $contact->name,
							'firstname' => $contact->firstname,
							'lastname' => $contact->lastname,
							'address1' => $contact->address1,
							'address2' => $contact->address2,
							'zipcode' => $contact->zipcode,
							'city' => $contact->city,
							'country' => $contact->country,
							'phone' => $contact->phone,
							'email' => $contact->email,
							'chamberOfCommerce' => $contact->chamberOfCommerce,
							'bankAccount' => $contact->bankAccount,
							'taxNumber' => $contact->taxNumber,
							'sendMethod' => $contact->sendMethod,
							'createdAt' => (is_object($contact->createdAt)) ? $contact->createdAt->format('Y-m-d H:i:s') : null,
							'updatedAt' => (is_object($contact->updatedAt)) ? $contact->updatedAt->format('Y-m-d H:i:s') : null,
						),
					);
					$list[] = $data;
					
					$this->modx->cacheManager->set('contacts/'.$data['data']['customerId'], $data['data'], 0, $this->modx->moneybird->config['cacheOptions']);
				}
				
				$this->modx->cacheManager->set('contacts/summary', $list, 0, $this->modx->moneybird->config['cacheOptions']);
			}
			
			// check list agains local relationship
			foreach($list as $index => $values) {
				$exists = $this->modx->getObject('mbRelation', array('customerid' => $values['data']['customerId']));
				if (!empty($exists) && is_object($exists)) {
					unset($list[$index]);
				}
			}
			
			// to reset array indexes double reverse it
			$list = array_reverse(array_reverse($list));
		}
		else {
			
			$contact = $this->modx->cacheManager->get('contacts/'.$id, $this->modx->moneybird->config['cacheOptions']);
			if(!empty($contact)) {
				
				// add to list
				$address1 = $contact['address1'];
				$address2 = $contact['address2'];
				if(!empty($address1) || !empty($address2)) {
					$text = $address1;
					if(!empty($text) && !empty($address2)) { $text .= ', '; }
					$text .= $address2;
					
					$list[] = array(
						'text' => $text,
						'id' => 'n_mbc_'.$contact['customerId'].'_1',
						'leaf' => true,
						'type' => 'MoneyBirdContactDetail',
						'cls' => 'none',
						'iconCls' => 'no-leaf-icons',
						'allowDrag' => false,
						'selectable' => false,
						'data' => array(),
					);
				}
				
				$zipcode = $contact['zipcode'];
				$city = $contact['city'];
				if(!empty($zipcode) || !empty($city)) {
					$text = $zipcode;
					if(!empty($text) && !empty($city)) { $text .= ', '; }
					$text .= $city;
					
					$list[] = array(
						'text' => $text,
						'id' => 'n_mbc_'.$contact['customerId'].'_2',
						'leaf' => true,
						'type' => 'MoneyBirdContactDetail',
						'cls' => 'none',
						'iconCls' => 'no-leaf-icons',
						'allowDrag' => false,
						'data' => array(),
					);
				}
				
				$country = $contact['country'];
				if(!empty($country)) {
					$list[] = array(
						'text' => $country,
						'id' => 'n_mbc_'.$contact['customerId'].'_3',
						'leaf' => true,
						'type' => 'MoneyBirdContactDetail',
						'cls' => 'none',
						'iconCls' => 'no-leaf-icons',
						'allowDrag' => false,
						'data' => array(),
					);
				}
				
				$email = $contact['email'];
				if(!empty($email)) {
					$list[] = array(
						'text' => $email,
						'id' => 'n_mbc_'.$contact['customerId'].'_4',
						'leaf' => true,
						'type' => 'MoneyBirdContactDetail',
						'cls' => 'none',
						'iconCls' => 'no-leaf-icons',
						'allowDrag' => false,
						'data' => array(),
					);
				}
			}
		}
		
		return $this->modx->toJSON($list);
	}
}
return 'MoneyBirdContactsGetListProcessor';

?>