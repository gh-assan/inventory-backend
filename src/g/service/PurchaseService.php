<?php

namespace g\service;

use g\interfaces\ModelInterface as IModel;
use g\service\BaseModelService as BaseModelService;

class PurchaseService extends BaseModelService{

	private $productTransactionDetailsModel ;	
	private $profileModel ;	
	private $productModel ;	
	

	public function __construct(IModel $productTransactionModel ,
		                        IModel $productTransactionDetailsModel,
	                            IModel $profileModel , 
	                            IModel $productModel)
	{
		parent::__construct($productTransactionModel);
		$this->productTransactionDetailsModel   = $productTransactionDetailsModel;
		$this->profileModel   = $profileModel;	
		$this->productModel   = $productModel;	
	}
	


	public function loadList(){
		
		return $this->model->loadList();
	}
	
	public function loadSingle($id){
	
		$purchase 	= $this->model->loadSingle($id); 
		$purchase['details'] = $this->productTransactionDetailsModel->loadDetailsByTransaction($id);    
		return $purchase;
	}


	public function insert($row){
		

		$userId =  $row->user_id;
		
        $profile = $this->profileModel->loadSingleByUserId($userId);
        $profile = $profile;
        
        if (!$this->isEmpty($row,'person_id'))
        	$personId    = $row->person_id;
        else
        	$personId    = $profile['customer_person_id'];

        
        if (!$this->isEmpty($row,'person_id_to'))
        	$personIdTo  =  $row->person_id_to;
        else
        	$personIdTo  =  $profile['shop_person_id'];


        if (!$this->isEmpty($row,'description'))
        	$description  =  $row->description;
        else
        	$description  =  'Auto insert';
        

     	$purchase['person_id'] = $personId;   
     	$purchase['person_id_to'] = $personIdTo;   
     	$purchase['type'] = 'P';   
     	$purchase['user_id'] = $userId;   
     	$purchase['description'] = $description;   
        
        
     	$id = $this->model->insert($purchase);


		foreach ($row->details as $key => $detail) {		 	
			$detail->product_transaction_id = $id ;
			$this->productTransactionDetailsModel->insert($detail);		 	

			$product = $this->productModel->loadSingle($detail->product_id);

			if ($product['price'] != $detail->price){
				$product['price'] = $detail->price;
				$product['user_id'] = $userId;
				$this->productModel->update($product);				
			}
		 } 

		
		
		return $id;
	}
	
	private function isEmpty($row , $key){

		if (isset($row->$key) && $row->$key != '')
			return false;
		else
			return true;
	}
}
