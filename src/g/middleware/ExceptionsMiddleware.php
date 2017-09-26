<?php

namespace g\middleware;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;


class ExceptionsMiddleware extends BaseMiddleWare   {

	protected  $logger;
	
	public function __construct($logger)
	{
		$this->logger = $logger;
	}


	public function __invoke(IRequest $request, IResponse $response, $next)
	{
		$this->logger->addInfo('ExceptionsMiddleware : Begin');
		$this->logger->addInfo($this->hasError($request, $response));
		
		try{
			$response = $next($request, $response);
		}catch (\Exception $e){
			
			$result = new \stdClass;				
			$result->Error = $e->getMessage();
			$response = $response->withJson($result)
								 ->withStatus(500)
			                      ;
			
			$response = $this->addHeaderError($request, $response);
			
		}
		
		$this->logger->addInfo($this->hasError($request, $response));
		$this->logger->addInfo('ExceptionsMiddleware : End');
		
		return $response;
	}

}