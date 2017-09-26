<?php

namespace g\api;

use \g\service\TransactionService;

class TransactionApi extends BaseApi {
		
	public function __construct( TransactionService $transactionService){
		parent::__construct($transactionService);	
	}
}