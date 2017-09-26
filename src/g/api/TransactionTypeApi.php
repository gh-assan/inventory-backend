<?php

namespace g\api;

use \g\service\TransactionTypeService;

class TransactionTypeApi extends BaseApi {
		
	public function __construct( TransactionTypeService $transactionTypeService){
		parent::__construct($transactionTypeService);	
	}
}