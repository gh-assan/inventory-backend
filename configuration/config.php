<?php

$config = [
		'settings' => [
				'displayErrorDetails' => false,
				'addContentLengthHeader'=> true,
				'determineRouteBeforeAppMiddleware'=> true,				
				'logger' => [
						'name' => 'slim-app',
						'level' => Monolog\Logger::ERROR,
						'path' => __DIR__."\..\logs\app.log"
				]
		]
];

/*
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['determineRouteBeforeAppMiddleware'] = true;
//$config['determineRouteBeforeAppMiddleware'] = true
*/

$config['db']['host']   = "localhost";
$config['db']['user']   = "user";
$config['db']['pass']   = "password";
$config['db']['dbname'] = "exampleapp";