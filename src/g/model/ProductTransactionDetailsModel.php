<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class ProductTransactionDetailsModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"inventory.product_transaction_detail" ,  'id' , 'pd');
		$this->columns = ['id','product_transaction_id','product_id','amount','price' ];
	}
	

	/**
     * Returns generated SQL.
     *
     * @return string
     */
    public function getSql()
    {
    	$this->columns[] = 'product_name'; 
        $where = (count($this->conditions) === 0)
            ? '' : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT pd.* , 
        p.name as product_name 
                FROM $this->table $this->alias    
                     left join inventory.product p on p.id = pd.product_id                     
                $where $this->order 
                $this->limit 
                $this->offset";
        return $sql;
    }

    public function loadList()
    {
    	$query = clone $this;
    	//$query->select = 'id';
    	return $query->execute();
    }


    public function loadDetailsByTransaction($tansactionId)
    {
        $query = clone $this;
        $query->addCondition("pd.product_transaction_id=$tansactionId");

        //$query->select = 'id';
        return $query->execute();
    }

}