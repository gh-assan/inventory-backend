<?php

namespace g\api;

use \g\service\AccountService;

class AccountApi extends BaseApi {
		
	public function __construct( AccountService $accountService){
		parent::__construct($accountService);	
	}
}