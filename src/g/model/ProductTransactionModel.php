<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class ProductTransactionModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"inventory.product_transaction" ,  'id' , 'pt');
		$this->columns = ['id','description','user_id','person_id','type' ,'creation_date' ,'person_id_to'];
	}
	

	/**
     * Returns generated SQL.
     *
     * @return string
     */
    public function getSql()
    {
    	$this->columns[] = 'user_name'; 
        $this->columns[] = 'person_name'; 
        $this->columns[] = 'person_name_to'; 
    	$where = (count($this->conditions) === 0)
            ? '' : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT pt.* , 
        pr.full_name as person_name , 
        pr2.full_name as person_name_to , 
        ur.first_name || ' ' || ur.last_name as user_name 
                FROM $this->table $this->alias    
                     left join cost.person pr  on pr.id  = pt.person_id
                     left join cost.person pr2 on pr2.id = pt.person_id_to
                     left join admin.user  ur  on ur.id  = pt.user_id                     
                $where $this->order 
                $this->limit 
                $this->offset";
        return $sql;
    }

    public function loadList()
    {
    	$query = clone $this;
        $query->clearConditions();
    	//$query->select = 'id';
    	return $query->execute();
    }
}