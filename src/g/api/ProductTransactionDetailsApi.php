<?php

namespace g\api;

use \g\service\ProductTransactionDetailsService;

class ProductTransactionDetailsApi extends BaseApi {
		
	public function __construct( ProductTransactionDetailsService $productTransactionDetailsService){
		parent::__construct($productTransactionDetailsService);	
	}
}