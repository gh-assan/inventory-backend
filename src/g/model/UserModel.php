<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class UserModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"admin.user");
		$this->columns = ['id','first_name','last_name','email','is_active'];
	}
	
	public function loadSingleByUserName($email)
	{
		$query = clone $this;
		
		$query->select = '*';		
		$query->addCondition("is_active = true");
		$query->addCondition("email = '$email' ");
				
		return $query->execute();
	}
	
}