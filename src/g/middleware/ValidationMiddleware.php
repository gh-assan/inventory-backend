<?php

namespace g\middleware;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;


class ValidationMiddleware   extends BaseMiddleWare {

	protected  $logger;
	
	public function __construct($logger)
	{
		$this->logger = $logger;
	}


	public function __invoke(IRequest $request, IResponse $response, $next)
	{
		
		$this->logger->addInfo('ValidationMiddleware : Begin');
		$this->logger->addInfo($this->hasError($request, $response));
		
		if($request->getAttribute('has_errors')){			
			$errors = $request->getAttribute('errors');
			$response = $response->withJson($errors);
			$response = $response->withStatus(400);
			
			$response = $this->signalError($request, $response);
			
		}else{					
			$response = $next($request, $response);
		}
		
		$this->logger->addInfo($this->hasError($request, $response));
		$this->logger->addInfo('ValidationMiddleware : End');
		
		return $response;
	}

}