<?php


namespace g\api;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;

use g\interfaces\ApiInterface as IApi;
use g\interfaces\ModelServiceInterface as IModelService;

use g\exception\apiException\NotValidIdException;


class BaseApi implements IApi{
	
	const GET  	= "GET";
	const POST 	= "POST";
	const PUT 	= "PUT";
	const DELETE 	= "DELETE";
	const OPTIONS 	= "options";
	
	protected $service;	
	
	public function __construct(IModelService $service)
	{
		$this->service = $service;
	}
	
	public function getAction(IRequest $request, IResponse $response, $args){				
		//echo "test api get : ".$request->getAttribute("id");		
		$result = $this->service->loadSingle($request->getAttribute("id")); 
		
		$response = $response->withJson($result);
		return $response;
		//echo json_encode($result);
	}
	
	public function listAction(IRequest $request, IResponse $response, $args){
	
		$result = $this->service->loadList(); 
		$response = $response->withJson($result);
		return $response;
		//echo json_encode($result);		
	}
	
	public function putAction(IRequest $request, IResponse $response, $args){
	
		
		$obj =  json_encode( $request->getParsedBody());
		$obj = json_decode($obj);
		
		$id = $request->getAttribute("id");
		$obj->id = $id;
		
		
		
		$success = $this->service->update($obj);
		
		$result = new \stdClass;
		$result->success = $success;
		
		$response = $response->withJson($result);
		$response = $response->withStatus(201);
		
		return $response;
		
	}
	
	public function postAction(IRequest $request, IResponse $response, $args){
	
		
		$obj =  json_encode( $request->getParsedBody());
		$obj = json_decode($obj);
		
		$id = $this->service->insert($obj);
		
		$result = new \stdClass;
		$result->id = $id;
		
		$response = $response->withJson($result);
		$response = $response->withStatus(201);
		return $response;
	}
	
	public function deleteAction(IRequest $request, IResponse $response, $args){
	
		
		$id = $request->getAttribute("id");
		
		if (! is_numeric($id) )
			throw new NotValidIdException; 
		
		$success = $this->service->delete($id);
		
		$result = new \stdClass;
			
		$result->success = $success;
		
		$response = $response->withJson($result);
		$response = $response->withStatus(201);
		
		return $response;
	}
	
	public function __invoke(IRequest $request, IResponse $response, $args) {
	
		switch (true){						
			case (self::GET == $request->getMethod() ):
				$response = $this->getAction($request, $response, $args);
				break;
			case (self::POST == $request->getMethod() ):
				$response = $this->postAction($request, $response, $args);				
				break;
			case (self::PUT == $request->getMethod() ):
				$response = $this->putAction($request, $response, $args);
				break;
			case (self::DELETE == $request->getMethod() ):
				$response = $this->deleteAction($request, $response, $args);
				break;
			case (self::OPTIONS == strtolower($request->getMethod()) ):
				break;				
			default:
				throw new \Exception();
		}
		
		return $response;
	}

	public function filterAction(IRequest $request, IResponse $response, $args){
	
		
		$obj =  json_encode( $request->getParsedBody());
		$obj = json_decode($obj);
		
		
		$queryItems 	= isset($obj->query)  ? $obj->query : []; 
		$offset 		= isset($obj->offset) ? $obj->offset : '';
		$limit 			= isset($obj->limit)  ? $obj->limit : '';
		$orderByColumn  = isset($obj->order)  ? $obj->order : '';

		$result = $this->service->filterList($queryItems,$offset ,$limit ,$orderByColumn);
		
		$response = $response->withJson($result);
		return $response;
		
	}
}


