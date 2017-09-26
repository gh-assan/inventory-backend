<?php

namespace g\service;


use g\interfaces\AuthlServiceInterface as IAuthlService;

use \Psr\Http\Message\ResponseInterface as IResponse;
use \Psr\Http\Message\ServerRequestInterface as IRequest;
use g\middleware\BaseMiddleWare;


class BasicAuthService  extends BaseMiddleWare implements IAuthlService  {

	
	protected $userService;		
	protected $realm;
	protected $logger;

	public function __construct($userService  , $logger,$realm = 'Protected Area')
	{
		
		$this->userService 		= $userService;
		$this->realm 			= $realm;
		$this->logger = $logger;
	}
	
	
	public function __invoke(IRequest $request, IResponse $response, $next)
	{
		$userValidated = false;
				
		if ($request->hasHeader('PHP_AUTH_USER') && $request->hasHeader('PHP_AUTH_PW')) {
								
			$authUser = $request->getHeader('PHP_AUTH_USER');
			$authPass = $request->getHeader('PHP_AUTH_PW');
										
			// see if an active user can be found with this email
			$userValidated = $this->userService->validate($authUser[0] , $authPass[0]);					
		}
		
		
		//$this->logger->addInfo('$userValidated : ' . json_encode($userValidated));
		
		if ($userValidated) {
			
			$user = $userValidated;
			
			//$this->logger->addInfo($user['name']);
			
			$response = $response->withHeader('USER_NAME' ,$user['name']);
			$response = $response->withHeader('USER_ID',$user['id']);
			
			$response = $next($request, $response);
		} else {
			$response = $response->withStatus(400);
			$data ["User"] = $authUser; 
			$data ["Password"] = $authPass;
			$data [] = "Not Authinticated";
						
			$response = $this->addHeaderError($request, $response);
			
			
			$response = $response->withJson($data);
			
			
			
			return $response;
		}
		
			
		return $response;
	}
	
}