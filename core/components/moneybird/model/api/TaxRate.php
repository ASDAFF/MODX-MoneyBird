<?php

/*
 * TaxRate class file
 */

namespace Moneybird;

/**
 * TaxRate
 */
class TaxRate extends Domainmodel_Abstract implements Mapper_Mapable {
	
	/**
	 * Rate type
	 * @const RATE_TYPE_SALES Rates for sales
	 */
	const RATE_TYPE_SALES = 1;
	
	/**
	 * Rate type
	 * @const RATE_TYPE_PURCHASE Rates for purchases
	 */
	const RATE_TYPE_PURCHASE = 2;
	
	protected $active;
	protected $createdAt;
	protected $id;
	protected $name;
	protected $percentage;
	protected $showTax;
	protected $taxRateType;
	protected $taxedItemType;
	protected $updatedAt;
	
	protected $_readonlyAttr = array(
		'active',
		'createdAt',
		'id',
		'name',
		'percentage',
		'showTax',
		'taxRateType',
		'taxedItemType',
		'updatedAt',
	);
}