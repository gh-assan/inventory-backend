<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class PersonModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"cost.person");
		$this->columns = ['id','full_name','address_details','mobile','email','phone','user_id'];
	}
	
}