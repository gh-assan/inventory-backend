<?php

$app->options('/{name}/{id}', "PersonApi");

$app->get('/hello/{name}', function (Request $request, Response $response) {
	$name = $request->getAttribute('name');
	$response->getBody()->write("Hello, $name");
		
	$this->logger->addInfo("11");

	$this->testService->test();

	return $response;
});

$app->get('/api', "g\api\TestApi::listAction");
$app->get('/api/{id}', "g\api\TestApi::getAction");

$app->get('/partner', "PartnerApi:listAction");
$app->get('/partner/{id}', "PartnerApi");
$app->delete('/partner/{id}', "PartnerApi");

$app->put('/partner/{id}', "PartnerApi")
->add('Validation')
->add(new \DavidePastore\Slim\Validation\Validation($PartnerValidators))
;


$app->post('/partner', "PartnerApi")
	->add('Validation')
	->add(new \DavidePastore\Slim\Validation\Validation($PartnerValidators))
;

$app->get('/user', "UserApi:listAction");
$app->get('/user/{id}', "UserApi");
$app->put('/user/{id}', "UserApi");
$app->delete('/user/{id}', "UserApi");

$app->post('/user', "UserApi")
//->add('Validation')
//->add(new \DavidePastore\Slim\Validation\Validation($validators))
;

$app->get('/api2', "TestApi:listAction");

$app->get('/test2', "PartnerApi");


$app->post('/usersssssss', function ($req, $res, $next) {
	
	if($req->getAttribute('has_errors')){
		//There are errors, read them
		$errors = $req->getAttribute('errors');
		//var_dump($errors);
		//echo "error";
		
		$body = $req->getParsedBody();
		$body ["error"]= $errors;
		//$req = $req->withParsedBody($body);
		$res = $res->withJson($body);
		//$res =  $next($req, $res);
		//echo json_encode($next);

		/* $errors contain:
		 array(
		 'username' => array(
		 '"davidepastore" must have a length between 1 and 10',
		 ),
		 'age' => array(
		 '"89" must be lower than or equals 20',
		 ),
		 );
		 */
	} else {
		echo "passed";
		//No errors
	}
})
->add('Validation')
->add(new \DavidePastore\Slim\Validation\Validation($validators))
;

/*--Person--*/
$app->get('/person', "PersonApi:listAction");
$app->get('/person/{id}', "PersonApi");
$app->delete('/person/{id}', "PersonApi");

$app->put('/person/{id}', "PersonApi")
//->add('Validation')
//->add(new \DavidePastore\Slim\Validation\Validation($PartnerValidators))
;

$app->post('/person', "PersonApi");





/*--Ledger--*/
$app->get('/ledger', "LedgerApi:listAction");
$app->get('/ledger/{id}', "LedgerApi");
$app->delete('/ledger/{id}', "LedgerApi");

$app->put('/ledger/{id}', "LedgerApi")
;

$app->post('/ledger', "LedgerApi");

/*--Account--*/
$app->get('/account', "AccountApi:listAction");
$app->get('/account/{id}', "AccountApi");
$app->delete('/account/{id}', "AccountApi");

$app->put('/account/{id}', "AccountApi")
;

$app->post('/account', "AccountApi");



/*TransactionType*/
$app->get('/transaction-type', "TransactionTypeApi:listAction");
$app->get('/transaction-type/{id}', "TransactionTypeApi");
$app->delete('/transaction-type/{id}', "TransactionTypeApi");

$app->put('/transaction-type/{id}', "TransactionTypeApi")
;

$app->post('/transaction-type', "TransactionTypeApi");


/*Transaction*/
$app->get('/transaction', "TransactionApi:listAction");
$app->get('/transaction/{id}', "TransactionApi");
$app->delete('/transaction/{id}', "TransactionApi");

$app->put('/transaction/{id}', "TransactionApi")
;

$app->post('/transaction', "TransactionApi");
$app->post('/transaction/filter', "TransactionApi:filterAction");

/*TransactionDetails*/
$app->get('/transaction-detail', "TransactionDetailsApi:listAction");
$app->get('/transaction-detail/{id}', "TransactionDetailsApi");
$app->get('/transaction-detail/transaction/{id}', "TransactionDetailsApi:listByTransactionAction");
$app->delete('/transaction-detail/{id}', "TransactionDetailsApi");

$app->put('/transaction-detail/{id}', "TransactionDetailsApi")
;

$app->post('/transaction-detail', "TransactionDetailsApi");




/**
------Inventory---------
*/


/* Product Type */
$app->get('/product-type', "ProductTypeApi:listAction");
$app->get('/product-type/{id}', "ProductTypeApi");
$app->delete('/product-type/{id}', "ProductTypeApi");
$app->put('/product-type/{id}', "ProductTypeApi");
$app->post('/product-type', "ProductTypeApi");


/* Product */
$app->get('/product', "ProductApi:listAction");
$app->get('/product/{id}', "ProductApi");
$app->delete('/product/{id}', "ProductApi");
$app->put('/product/{id}', "ProductApi");
$app->post('/product', "ProductApi");
$app->post('/product/filter', "ProductApi:filterAction");


/* Product Transaction*/
$app->get('/product-transaction', "ProductTransactionApi:listAction");
$app->get('/product-transaction/{id}', "ProductTransactionApi");
$app->delete('/product-transaction/{id}', "ProductTransactionApi");
$app->put('/product-transaction/{id}', "ProductTransactionApi");
$app->post('/product-transaction', "ProductTransactionApi");

/* Product Transaction Details*/
$app->get('/product-transaction-details', "ProductTransactionDetailsApi:listAction");
$app->get('/product-transaction-details/{id}', "ProductTransactionDetailsApi");
$app->delete('/product-transaction-details/{id}', "ProductTransactionDetailsApi");
$app->put('/product-transaction-details/{id}', "ProductTransactionDetailsApi");
$app->post('/product-transaction-details', "ProductTransactionDetailsApi");




/* Purchase */
//$app->get('/product-transaction-details', "ProductTransactionDetailsApi:listAction");
$app->get('/purchase', "PurchaseApi:listAction");
$app->get('/purchase/{id}', "PurchaseApi");
//$app->delete('/product-transaction-details/{id}', "ProductTransactionDetailsApi");
//$app->put('/product-transaction-details/{id}', "ProductTransactionDetailsApi");
$app->post('/purchase', "PurchaseApi");
