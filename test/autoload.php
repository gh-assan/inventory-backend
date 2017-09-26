<?php
/*
 * to run the test cases 
 * from test folder
 * phpunit  .
 * To run specific test  
 * phpunit  g/service/UserServiceTest
 */

$autoloader = require dirname(__DIR__) . '/vendor/autoload.php';
$autoloader->addPsr4('Slim\Tests\\', __DIR__);