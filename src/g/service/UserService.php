<?php

namespace g\service;

use g\interfaces\ModelInterface as IModel;
use g\service\BaseModelService as BaseModelService;


class UserService extends BaseModelService{
	
	protected $bcryptService;
	
	public function __construct(IModel $model , $bcryptService)
	{
		parent::__construct($model);
		
		$this->bcryptService = $bcryptService;
	}
	
	public function loadSingleByUserName($email){
		$row =   $this->model->loadSingleByUserName($email);	
		return $row[0];
	}
	
	
	public function validate($email, $password){
		
		if ($email == '' && $password == '')
			return false;
		
		$row =   $this->loadSingleByUserName($email);	
		$validated = $this->bcryptService->verify($password, $row['password']);
		
		if($validated)
			return $row;
		
		return false;
		
		//return $this->bcryptService->verify($password, $row['password']);
	}
	
}
