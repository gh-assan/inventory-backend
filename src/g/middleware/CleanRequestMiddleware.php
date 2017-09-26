<?php

namespace g\middleware;

use g\interfaces\CleanRequestInterface as ICleanRequest;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;
use g\service\StringService;


class CleanRequestMiddleware  extends BaseMiddleWare implements ICleanRequest  {

	protected $stringService;
	protected  $logger;

	public function __construct($stringService , $logger)
	{
		$this->stringService 		= $stringService;		
		$this->logger = $logger;
	}


	public function __invoke(IRequest $request, IResponse $response, $next)
	{
		$this->logger->addInfo('CleanRequestMiddleware : Begin');
						
		$this->logger->addInfo($this->hasError($request, $response));
		
		$body = $request->getParsedBody();		
		$body = $this->stringService->sanitize($body);
		
		if (! $this->stringService->is_empty($body) ){					
			$request = $request->withParsedBody($body);
		}
		
		$response = $next($request, $response);
		
		
		
		$this->logger->addInfo($this->hasError($request, $response));
		$this->logger->addInfo('CleanRequestMiddleware : End');
		
		return $response;
	}

}