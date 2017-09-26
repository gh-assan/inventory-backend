<?php

namespace g\api;

use \g\service\ProductService;

class ProductApi extends BaseApi {
		
	public function __construct( ProductService $productService){
		parent::__construct($productService);	
	}
}