<?php

/*
 * Contact service class
 */

namespace Moneybird;

/**
 * Contact service
 */
class Contact_Service implements Service {
	
	/**
	 * ApiConnector object
	 * @var ApiConnector
	 */
	protected $connector;
	
	/**
	 * Constructor
	 * @param ApiConnector $connector 
	 */
	public function __construct(ApiConnector $connector) {
		$this->connector = $connector;
	}
	
	/**
	 * Get contacts sync status
	 * @return Contact_Array
	 */
	public function getSyncList() {
		return $this->connector->getSyncList('Contact');
	}
	
	/**
	 * Get contact by id
	 * @param int $id
	 * @return Contact
	 */
	public function getById($id) {
		return $this->connector->getById('Contact', $id);
	}
	
	/**
	 * Get contacts by id (max 100)
	 * @param Array $ids
	 * @return Contact_Array
	 */
	public function getByIds($ids) {
		return $this->connector->getByIds('Contact', $ids);
	}
	
	/**
	 * Get all contacts
	 * 
	 * @return Contact_Array
	 */
	public function getAll() {
		return $this->connector->getAll('Contact');
	}	
	
	/**
	 * Get contact by customer id
	 * @param string $customerId
	 * @return Contact
	 */
	public function getByCustomerId($customerId) {
		return $this->connector->getByNamedId('Contact', 'customer_id', $customerId);
	}
	
	/**
	 * Updates or inserts a contact
	 * @param Contact $contact
	 * @return Contact
	 */
	public function save(Contact $contact) {
		return $this->connector->save($contact);
	}
	
	/**
	 * Deletes a contact
	 * @param Contact $contact
	 * @return self
	 */
	public function delete(Contact $contact) {
		$this->connector->delete($contact);
		return $this;
	}
}