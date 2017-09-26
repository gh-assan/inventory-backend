<?php

namespace g\api;

use \g\service\PersonService;

class PersonApi extends BaseApi {
		
	public function __construct( PersonService $personService){
		parent::__construct($personService);	
	}
}