<?php

namespace g\api;

use \g\service\ProductTransactionService;

class ProductTransactionApi extends BaseApi {
		
	public function __construct( ProductTransactionService $productTransactionService){
		parent::__construct($productTransactionService);	
	}
}