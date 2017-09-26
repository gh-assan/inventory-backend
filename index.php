<?php

// php -S 127.0.0.1:1111 -t .
// composer dump-autoload

require_once __DIR__.'/vendor/autoload.php';

include  __DIR__.'/configuration/config.php'; 
include  __DIR__.'/configuration/services.php';

//$app = new \Slim\App($container);


include  __DIR__.'/configuration/validators.php';
include  __DIR__.'/configuration/routes.php';
include  __DIR__.'/configuration/middleware.php';
//include  __DIR__.'/configuration/routes.php';


$app->run();


	