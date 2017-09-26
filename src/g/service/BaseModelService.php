<?php

namespace g\service;

use g\interfaces\ModelServiceInterface as IModelService;
use g\interfaces\ModelInterface as IModel;
use g\exception\modelException\NotFoundException;


class BaseModelService implements IModelService  {
	
	protected $model; 
	
	public function __construct(IModel $model)
	{
		//parent::__construct();
		
		$this->model = $model;
	}
	
	
	public function loadList(){
		
		return $this->model->loadList();
	}
	
	public function loadSingle($id){
	
		return $this->model->loadSingle($id);
	}
	
	public function delete($id){
			
		// check if the row exist before updating it
		$row = $this->model->loadSingle($id);
		if(!$row)
			throw new NotFoundException(" $id Not Found ");
		
		return $this->model->delete($id);
	}
	
	public function insert($row){
	
		return $this->model->insert($row);
	}
	
	public function update($row){
		
		$id = $row->id;
		
		// check if the row exist before updating it
		$old_row = $this->model->loadSingle($id);
		if(!$old_row)
			throw new NotFoundException(" $id Not Found "); 
	
		return $this->model->update($row);
	}


	public function filterList($queryItems , $offset , $limit, $orderByColumn){
		
		return $this->model->filterList($queryItems,$offset ,$limit ,$orderByColumn);
	}

}