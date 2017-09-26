<?php

namespace g\api;

use \g\service\PurchaseService;

class PurchaseApi extends BaseApi {
		
	public function __construct( PurchaseService $purchaseService){
		parent::__construct($purchaseService);	
	}
}