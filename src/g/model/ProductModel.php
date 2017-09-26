<?php

namespace g\model;

use g\model\BaseModel as BaseModel;
use g\interfaces\ConnectInterface as IConnection;


class ProductModel extends BaseModel {
	
	public function __construct(IConnection $connection)
	{
		parent::__construct($connection,"inventory.product" , 'id' , 'pr');
		$this->columns = ['id','name','description','product_type_id','creation_date','update_date','user_id','price'];
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
        

    	$this->columns[] = 'product_type'; 
    	$this->columns[] = 'user_name'; 
    	$where = (count($this->conditions) === 0)
            ? '' : 'WHERE ' . implode(' and ', $this->conditions);
        $sql = "SELECT pr.* , pt.name as product_type , ur.first_name || ' ' || ur.last_name as user_name 
                FROM $this->table $this->alias    
                     left join inventory.product_type pt on pt.id = pr.product_type_id
                     left join admin.user  ur on ur.id = pr.user_id
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