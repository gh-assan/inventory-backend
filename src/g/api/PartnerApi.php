<?php

namespace g\api;

use \g\service\PartnerService;

class PartnerApi extends BaseApi {
		
	public function __construct( PartnerService $partnerService){
		parent::__construct($partnerService);	
	}
}