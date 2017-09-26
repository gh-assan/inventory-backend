<?php

namespace g\middleware;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;



class AccessControlAllowOriginMiddleware  extends BaseMiddleWare   {

	protected  $logger;

	public function __construct( $logger)
	{
		$this->logger = $logger;
	}


	public function __invoke(IRequest $request, IResponse $response, $next)
	{
		$this->logger->addInfo('AccessControlAllowOriginMiddleware : Begin');
						
		$route = $request->getAttribute("route");
		
		$methods = ['DELETE','PUT','POST']	;
		
		$methods[] = $request->getMethod();


		$response = $next($request, $response);
		
		$response =  $response->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
							  ->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
		                      ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
		;
		
		$this->logger->addInfo($this->hasError($request, $response));
		$this->logger->addInfo('AccessControlAllowOriginMiddleware : End');
		
		return $response;
	}

}