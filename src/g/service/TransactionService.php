<?php

namespace g\service;

use g\interfaces\ModelInterface as IModel;
use g\service\BaseModelService as BaseModelService;


class TransactionService extends BaseModelService{

	private $transactionDetailsModel ;
	private $transactionTypeModel;

	public function __construct(IModel $model , IModel $transactionDetailsModel ,IModel $transactionTypeModel)
	{
		parent::__construct($model);
		$this->transactionDetailsModel  = $transactionDetailsModel;
		$this->transactionTypeModel 	= $transactionTypeModel;
	}
	
	public function insert($row){
	
		$id = $this->model->insert($row);


		$transaction_type 	= $this->transactionTypeModel->loadSingle($row->transaction_type_id);
		$fromAccount 		= $row->account_id_from;
		$toAccount 			= $row->account_id_to;
		$numberOfPayments	= $row->num_of_payments;
		$creationDate 		= $row->creation_date;

		$amount 			= floor($row->total_amount / $numberOfPayments);


		// prepare transactionDetails row
		$transactionDetails = [];
		//$transactionDetails 

		$transactionDetails['transaction_id'] = $id;  
		$transactionDetails['amount'] = $amount;  
		$transactionDetails['account_id_from'] =  $fromAccount;  
		$transactionDetails['account_id_to'] = $toAccount;  
		$transactionDetails['creation_date'] = $creationDate;  

		
		// transaction_id , amount , schedule_date ,account_id_from , account_id_to	

		$schedule_date = '';

		for ($i = 0 ; $i < $numberOfPayments ; $i++){

			$schedule_date = $this->transactionDetailsModel->getScheduleDate($schedule_date,$transaction_type["due_date"]);
			$schedule_date = $schedule_date[0]['schedule_date'];

			$transactionDetails['schedule_date'] = $schedule_date;  

			$this->transactionDetailsModel->insert($transactionDetails);			
		}
		
		return $id;
	}
	
}
