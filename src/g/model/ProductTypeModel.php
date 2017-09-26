<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class ProductTypeModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"inventory.product_type");
		$this->columns = ['id','name','description'];
	}
	
}