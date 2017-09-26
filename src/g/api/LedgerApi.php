<?php

namespace g\api;

use \g\service\LedgerService;

class LedgerApi extends BaseApi {
		
	public function __construct( LedgerService $ledgerService){
		parent::__construct($ledgerService);	
	}
}