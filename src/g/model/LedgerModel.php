<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class LedgerModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"cost.ledger");
		$this->columns = ['id','name','description'];
	}
	
}