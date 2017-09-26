<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class TransactionTypeModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"cost.transaction_type");
		$this->columns = ['id','name','description','due_date'];
	}
	
}