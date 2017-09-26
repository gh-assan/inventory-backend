<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class PartnerModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"marketing.partner_account");
		$this->columns = ['id','name','account_manager','is_active'];
	}
}