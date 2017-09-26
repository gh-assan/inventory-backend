<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class AccountModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"cost.account" ,  'id' , 'ac');
		$this->columns = ['id','name','description','user_id','person_id','ledger_id'];
	}
	

	/**
     * Returns generated SQL.
     *
     * @return string
     */
    public function getSql()
    {
    	$this->columns[] = 'ledger'; 
    	$this->columns[] = 'user_name'; 
    	$where = (count($this->conditions) === 0)
            ? '' : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT ac.* , ld.name as ledger , ur.first_name || ' ' || ur.last_name as user_name 
                FROM $this->table $this->alias    
                     left join cost.ledger ld on ld.id = ac.ledger_id
                     left join admin.user  ur on ur.id = ac.user_id
                $where $this->order 
                $this->limit 
                $this->offset";
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