<?php


namespace g\api;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;
use g\interfaces\ApiInterface;

class TestApi implements ApiInterface  {
	
	const GET  	= "GET";
	const POST 	= "POST";
	const PUT 	= "PUT";
	const DELETE 	= "DELETE";
	
		
	public function getAction(IRequest $request, IResponse $response, $args){				
		echo "test api get";		
		$this->testService->test();
	}
	
	public function listAction(IRequest $request, IResponse $response, $args){
	
		echo "test api list";
	}
	
	public function putAction(IRequest $request, IResponse $response, $args){
	
		echo "test api put";
	}
	
	public function postAction(IRequest $request, IResponse $response, $args){
	
		echo "test api post";
	}
	
	public function deleteAction(IRequest $request, IResponse $response, $args){
	
		echo "test api delete";
	}
	
	public function __invoke(IRequest $request, IResponse $response, $args) {
	
		echo "test api __invoke \n <br>";
		
		
		switch (true){						
			case (self::GET == $request->getMethod() ):
				$this->getAction($request, $response, $args);
				break;
			case (self::POST == $request->getMethod() ):
				$this->postAction($request, $response, $args);				
				break;
			case (self::PUT == $request->getMethod() ):
				$this->putAction($request, $response, $args);
				break;
			case (self::DELETE == $request->getMethod() ):
				$this->deleteAction($request, $response, $args);
				break;
			default:
				throw new \Exception();
		}
	}
}


