<?php

namespace g\service;

use g\interfaces\ModelInterface as IModel;
use g\service\BaseModelService as BaseModelService;


class ProductTypeService extends BaseModelService{
	
	public function __construct(IModel $model)
	{
		parent::__construct($model);
	}
	
}
