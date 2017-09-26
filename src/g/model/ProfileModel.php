<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class ProfileModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"config.profile" , 'id','cp');
		$this->columns = ['id','shop_person_id','default_account_id','customer_person_id'];
	}
	


    /**
     * Returns generated SQL.
     *
     * @return string
     */
    public function getSql()
    {
    	$this->columns[] = 'user_name'; 
        $this->columns[] = 'shop_person_name'; 
        $this->columns[] = 'customer_person_name'; 
        $this->columns[] = 'account'; 
    	$where = (count($this->conditions) === 0)
            ? '' : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT cp.* , 
        pr.full_name as shop_person_name , 
        pr2.full_name as customer_person_name , 
        ac.name as account_name , 
        ur.first_name || ' ' || ur.last_name as user_name 
                FROM $this->table $this->alias    
                     left join cost.person pr  on pr.id  = cp.shop_person_id
                     left join cost.person pr2 on pr2.id = cp.customer_person_id
                     left join admin.user  ur  on ur.profile_id  = cp.id                     
                     left join cost.account  ac  on ac.id  = cp.default_account_id                     
                $where $this->order 
                $this->limit 
                $this->offset";
        //var_dump($sql);
        return $sql;
    }


	public function loadSingleByUserId($userId)
	{
		$query = clone $this;
		
		$query->select = 'cp.*';		
		$query->addCondition("ur.id = $userId");
				

        $row = $query->execute();

        if (sizeof($row) > 0  ){
            return  $row[0];
        }
        else{
            throw  new NotFoundException(" No profile found for user $userId ");
        }        
		

	}
	
}