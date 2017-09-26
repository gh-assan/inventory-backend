<?php

namespace g\interfaces;

use \Psr\Http\Message\ServerRequestInterface as IRequest;
use \Psr\Http\Message\ResponseInterface as IResponse;


interface ApiInterface {

	public function getAction(IRequest $request, IResponse $response, $args);
	
	public function listAction(IRequest $request, IResponse $response, $args);
	
	public function putAction(IRequest $request, IResponse $response, $args);
	
	public function postAction(IRequest $request, IResponse $response, $args) ;
	
	public function deleteAction(IRequest $request, IResponse $response, $args) ;
		
	//public function __invoke(IRequest $request, IResponse $response, $args) ;
}