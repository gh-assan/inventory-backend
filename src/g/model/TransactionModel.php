<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class TransactionModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"cost.transaction" ,  'id' , 'tr');
		$this->columns = ['id','description','user_id','person_id','transaction_type_id' ,
                         'creation_date','update_date','total_amount','validation_date','notes' ];
	}
	

	/**
     * Returns generated SQL.
     *
     * @return string
     */
    public function getSql()
    {

        $order = (trim($this->order) === '') ? '' : ' order by ' .$this->order;
        $limit = (trim($this->limit) === '') ? '' : ' limit ' . $this->limit;
        $offset = (trim($this->offset) === '') ? '' : ' offset ' . $this->offset;
            

    	$this->columns[] = 'transaction_type'; 
    	$this->columns[] = 'user_name'; 
        $this->columns[] = 'person_name'; 
    	$where = (count($this->conditions) === 0)
            ? '' : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT tr.* , 
        tt.name as transaction_type, 
        pr.full_name as person_name , 
        ur.first_name || ' ' || ur.last_name as user_name 
                FROM $this->table $this->alias    
                     left join cost.person pr on pr.id = tr.person_id
                     left join admin.user  ur on ur.id = tr.user_id
                     left join cost.transaction_type  tt on tt.id = tr.transaction_type_id
                $where 
                $order 
                $limit 
                $offset";
        //var_dump($sql);
        return $sql;
    }

    public function loadList()
    {
    	$query = clone $this;
    	//$query->select = 'id';
    	return $query->execute();
    }
}