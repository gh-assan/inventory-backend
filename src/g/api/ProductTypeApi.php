<?php

namespace g\api;

use \g\service\ProductTypeService;

class ProductTypeApi extends BaseApi {
		
	public function __construct( ProductTypeService $productTypeService){
		parent::__construct($productTypeService);	
	}
}