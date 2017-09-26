<?php

namespace g\middleware;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;


class BaseMiddleWare
{
	public function __construct()
	{
		
	}
	
	public function hasError(IRequest $request, IResponse $response ){
		
		$result = false;
		
		if ($response->hasHeader('HAS_ERROR') ) {
			$result = true;			
		}
		
		return $result;
	}
	
	public function addHeaderError(IRequest $request, IResponse $response){
						
		$response = $response->withHeader('HAS_ERROR' , true);
		
		$this->logger->addInfo('BaseMiddleWare->addHeaderError');
		
		return $response;
	}
	
}