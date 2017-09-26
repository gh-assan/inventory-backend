<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class TransactionDetailsModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"cost.transaction_detail" ,  'id' , 'td');
		$this->columns = ['id','creation_date','transaction_id','amount','received_date' ,
                         'schedule_date','cancellation_date','cancellation_reason','cancelled_by','account_id_from','account_id_to' ];
	}
	

	/**
     * Returns generated SQL.
     *
     * @return string
     */
    public function getSql()
    {
    	$this->columns[] = 'account_from'; 
        $this->columns[] = 'account_to'; 
        $this->columns[] = 'cancelled_by_name'; 
    	$where = (count($this->conditions) === 0)
            ? '' : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT td.* , ac.name as account_from , ac2.name as account_to,
        ur.first_name || ' ' || ur.last_name as cancelled_by_name 
                FROM $this->table $this->alias    
                     left join admin.user  ur on ur.id = td.cancelled_by
                     left join cost.account  ac on ac.id = td.account_id_from
                     left join cost.account  ac2 on ac2.id = td.account_id_to                     
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
        $query->addCondition("td.transaction_id=$tansactionId");

        //$query->select = 'id';
        return $query->execute();
    }


    public function getScheduleDate($startDate , $interval )
    {
        $sql = "select (coalesce (:startDate,now() )::date + interval '$interval')::date as schedule_date";

        $row = [];
        $row['startDate'] = $startDate;    
        
        $query = clone $this;
        
        $result = $query->executeExternalStatement($sql , $row);
        
        return $result;
    }
    

}