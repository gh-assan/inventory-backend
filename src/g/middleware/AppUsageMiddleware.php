<?php

namespace g\middleware;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;


class AppUsageMiddleware  extends BaseMiddleWare  {

	protected  $appUsageService;
	protected  $logger;
	
	public function __construct($appUsageService , $logger)
	{
		$this->appUsageService = $appUsageService;
		$this->logger = $logger;
	}


	public function __invoke(IRequest $request, IResponse $response, $next)
	{
	
		$this->logger->addInfo('AppUsageMiddleware : Begin');
		
		$this->logger->addInfo($this->hasError($request, $response));
		
		
		
		$start_time = round(microtime(true) * 1000) ;
		
		$response = $response->withHeader('REQUEST_START_TIME' , $start_time);
		
		$response = $next($request, $response);
		
		if (!$this->hasError($request, $response)){
			
		
			$end_time = round(microtime(true) * 1000) ; 
			$response = $response->withHeader('REQUEST_END_TIME' , $end_time);
			
			$row = new \stdClass;
			
			$row->user_id         = $this->getUserId($response);
			$row->url             = $this->getRoute($request);
			$row->creation_date   = 'now()';
			$row->load_time		  = $end_time - $start_time ;
						
			
			$this->appUsageService->insert($row);
								
			
			$this->logger->addInfo('AppUsageMiddleware : ' . json_encode( $response->getHeader('REQUEST_START_TIME') ) . json_encode( $response->getHeader('REQUEST_END_TIME')));
		}
		
		
		$this->logger->addInfo($this->hasError($request, $response));
		$this->logger->addInfo('AppUsageMiddleware : End');
		
		return $response;
	}
	
	protected function getUserId(IResponse $response){
	
		$id = '';
		if ($response->hasHeader('USER_ID') ) {
			$UserId = $response->getHeader('USER_ID');
			$id   = $UserId[0];
		}
		
		$this->logger->addInfo('getUserId : ' .json_encode($id));
	
		return $id;
	}
	
	
	protected function getRoute(IRequest $request){
		
		$routeName = '';
		
		
		$routeName = $request->getUri()->getPath();
		
		$this->logger->addInfo('Route Name : ' .json_encode($routeName) );
		
		
		return $routeName;
	}
}