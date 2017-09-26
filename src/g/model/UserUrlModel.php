<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class UserUrlModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"admin.user_url");
		$this->columns = ['id','user_id','url','creation_date','load_time'];
	}
		
}