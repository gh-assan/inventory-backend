<?php

namespace g\api;

use \g\service\TransactionDetailsService;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;


class TransactionDetailsApi extends BaseApi {
		
	public function __construct( TransactionDetailsService $transactionDetailsService){
		parent::__construct($transactionDetailsService);	
	}


	public function listByTransactionAction(IRequest $request, IResponse $response, $args){
		
		$tansactionId = $request->getAttribute("id");
		$result = $this->service->loadDetailsByTransaction($tansactionId); 
		$response = $response->withJson($result);
		return $response;
		//echo json_encode($result);		
	}
	
}