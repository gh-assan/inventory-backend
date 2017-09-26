<?php

namespace g\api;

use \g\interfaces\ModelServiceInterface as IService;

class UserApi extends BaseApi {
		
	public function __construct(IService $userService){
		parent::__construct($userService);	
	}
}