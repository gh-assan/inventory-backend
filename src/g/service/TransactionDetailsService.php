<?php

namespace g\service;

use g\interfaces\ModelInterface as IModel;
use g\service\BaseModelService as BaseModelService;


class TransactionDetailsService extends BaseModelService{
	
	public function __construct(IModel $model)
	{
		parent::__construct($model);
	}
	

	public function loadDetailsByTransaction($tansactionId){
	
		return $this->model->loadDetailsByTransaction($tansactionId);
	}
}
