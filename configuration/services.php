<?php

$app = new \Slim\App($config);

$container = $app->getContainer();

//$container = new \Slim\Container($config);


// **** Settings ********************//

$container['logger'] = function($c) {
	/*
	$logger = new \Monolog\Logger('my_logger');
	$file_handler = new \Monolog\Handler\StreamHandler(__DIR__."\..\logs\app.log");
	$logger->pushHandler($file_handler);
	*/
	
	$settings = $c->get('settings')['logger'];
	$logger = new \Monolog\Logger($settings['name']);
	$logger->pushProcessor(new Monolog\Processor\UidProcessor());
	$logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
	
	
	return $logger;
};

// **** Models ********************//


$container['Connection'] = function($c) {
	$connection = new \g\provider\connection\PostgresConnectionImpl();
	return $connection;
};

/*
$container['Connection'] = function($c) {
	$connection = new \g\provider\connection\SqliteConnectionImpl();
	return $connection;
};
*/

$container['PartnerModel'] = function($c) {
	$model = new \g\model\PartnerModel($c['Connection']);
	return $model;
};

$container['UserModel'] = function($c) {
	$model = new \g\model\UserModel($c['Connection']);
	return $model;
};

$container['UserUrlModel'] = function($c) {
	$model = new \g\model\UserUrlModel($c['Connection']);
	return $model;
};

$container['PersonModel'] = function($c) {
	$model = new \g\model\PersonModel($c['Connection']);
	return $model;
};

$container['LedgerModel'] = function($c) {
	$model = new \g\model\LedgerModel($c['Connection']);
	return $model;
};

$container['AccountModel'] = function($c) {
	$model = new \g\model\AccountModel($c['Connection']);
	return $model;
};


$container['TransactionTypeModel'] = function($c) {
	$model = new \g\model\TransactionTypeModel($c['Connection']);
	return $model;
};


$container['TransactionModel'] = function($c) {
	$model = new \g\model\TransactionModel($c['Connection']);
	return $model;
};

$container['TransactionDetailsModel'] = function($c) {
	$model = new \g\model\TransactionDetailsModel($c['Connection']);
	return $model;
};


$container['ProductTypeModel'] = function($c) {
	$model = new \g\model\ProductTypeModel($c['Connection']);
	return $model;
};


$container['ProductModel'] = function($c) {
	$model = new \g\model\ProductModel($c['Connection']);
	return $model;
};


$container['ProductTransactionModel'] = function($c) {
	$model = new \g\model\ProductTransactionModel($c['Connection']);
	return $model;
};

$container['ProductTransactionDetailsModel'] = function($c) {
	$model = new \g\model\ProductTransactionDetailsModel($c['Connection']);
	return $model;
};


$container['ProfileModel'] = function($c) {
	$model = new \g\model\ProfileModel($c['Connection']);
	return $model;
};



// **** Services  ********************//

$container['testService'] = function($c) {
	$testService = new \g\service\TestService();
	return $testService;
};


$container['BcryptService'] = function($c) {
	$testService = new \g\service\BcryptService();
	return $testService;
};



$container['PartnerService'] = function($c) {
	$service = new \g\service\PartnerService($c['PartnerModel']);	
	return $service;
};

$container['UserService'] = function($c) {
	$service = new \g\service\UserService($c['UserModel'],$c['BcryptService']);
	return $service;
};

$container['appUsageService'] = function($c) {
	$service = new \g\service\AppUsageService($c['UserUrlModel']);
	return $service;
};

$container['StringService'] = function($c) {
	$service = new \g\service\StringService();
	return $service;
};




/*
$container['AuthService'] = function($c) {
	$service = new \g\service\BasicAuthService($c['UserService']);
	return $service;
};
*/


$container['PersonService'] = function($c) {
	$service = new \g\service\PersonService($c['PersonModel']);
	return $service;
};

$container['LedgerService'] = function($c) {
	$service = new \g\service\LedgerService($c['LedgerModel']);
	return $service;
};

$container['AccountService'] = function($c) {
	$service = new \g\service\AccountService($c['AccountModel']);
	return $service;
};


$container['TransactionTypeService'] = function($c) {
	$service = new \g\service\TransactionTypeService($c['TransactionTypeModel']);
	return $service;
};

$container['TransactionService'] = function($c) {
	$service = new \g\service\TransactionService($c['TransactionModel'],
														 $c['TransactionDetailsModel'],
														 $c['TransactionTypeModel']);
	return $service;
};


$container['TransactionDetailsService'] = function($c) {
	$service = new \g\service\TransactionDetailsService($c['TransactionDetailsModel']);
	return $service;
};


$container['ProductTypeService'] = function($c) {
	$service = new \g\service\ProductTypeService($c['ProductTypeModel']);
	return $service;
};


$container['ProductService'] = function($c) {
	$service = new \g\service\ProductService($c['ProductModel']);
	return $service;
};


$container['ProductTransactionService'] = function($c) {
	$service = new \g\service\ProductTransactionService($c['ProductTransactionModel']);
	return $service;
};

$container['ProductTransactionDetailsService'] = function($c) {
	$service = new \g\service\ProductTransactionDetailsService($c['ProductTransactionDetailsModel']);
	return $service;
};

$container['PurchaseService'] = function($c) {
	$service = new \g\service\PurchaseService(
		                $c['ProductTransactionModel'],
		                $c['ProductTransactionDetailsModel'],
		                $c['ProfileModel'],
		                $c['ProductModel']
		       );
	return $service;
};




// **** API  ********************//

$container['PartnerApi'] = function($c) {
	$api = new \g\api\PartnerApi($c['PartnerService']);	
	return $api;
};

$container['UserApi'] = function($c) {
	$api = new \g\api\UserApi($c['UserService']);
	return $api;
};

$container['TestApi'] = function($c) {
	$api = new \g\api\TestApi();	
	return $api;
};


$container['TransactionTypeApi'] = function($c) {
	$api = new \g\api\TransactionTypeApi($c['TransactionTypeService']);	
	return $api;
};


$container['TransactionApi'] = function($c) {
	$api = new \g\api\TransactionApi($c['TransactionService']);	
	return $api;
};


$container['TransactionDetailsApi'] = function($c) {
	$api = new \g\api\TransactionDetailsApi($c['TransactionDetailsService']);	
	return $api;
};


$container['ProductTypeApi'] = function($c) {
	$api = new \g\api\ProductTypeApi($c['ProductTypeService']);	
	return $api;
};


$container['ProductApi'] = function($c) {
	$api = new \g\api\ProductApi($c['ProductService']);	
	return $api;
};


$container['ProductTransactionApi'] = function($c) {
	$api = new \g\api\ProductTransactionApi($c['ProductTransactionService']);	
	return $api;
};


$container['ProductTransactionDetailsApi'] = function($c) {
	$api = new \g\api\ProductTransactionDetailsApi($c['ProductTransactionDetailsService']);	
	return $api;
};


$container['PurchaseApi'] = function($c) {
	$api = new \g\api\PurchaseApi($c['PurchaseService']);	
	return $api;
};




// **** middleware  ********************//

$container['AuthService'] = function($c) {
	$service = new \g\service\BasicAuthService($c['UserService'], $c['logger']);
	return $service;
};

$container['CleanRequest'] = function($c) {
	$service = new \g\middleware\CleanRequestMiddleware($c['StringService'], $c['logger']);
	return $service;
};

$container['Validation'] = function($c) {
	$service = new \g\middleware\ValidationMiddleware( $c['logger']);
	return $service;
};

$container['ExceptionsMiddleware'] = function($c) {
	$service = new \g\middleware\ExceptionsMiddleware( $c['logger']);
	return $service;
};

$container['appUsage'] = function($c) {
	$service = new \g\middleware\AppUsageMiddleware($c['appUsageService'] , $c['logger']);
	return $service;
};

$container['accessControl'] = function($c) {
	$service = new \g\middleware\AccessControlAllowOriginMiddleware( $c['logger']);
	return $service;
};


$container['PersonApi'] = function($c) {
	$api = new \g\api\PersonApi($c['PersonService']);
	return $api;
};


$container['LedgerApi'] = function($c) {
	$api = new \g\api\LedgerApi($c['LedgerService']);
	return $api;
};

$container['AccountApi'] = function($c) {
	$api = new \g\api\AccountApi($c['AccountService']);
	return $api;
};
