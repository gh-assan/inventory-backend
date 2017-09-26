<?php

namespace g\model;

use PDO;
use g\interfaces\ModelInterface as IModel;
use g\model\PdoConnection as PdoConnection;
use g\exception\modelException\NotFoundException;
use g\exception\modelException\NotCorrectInsertStatement;
use g\interfaces\ConnectInterface as IConnection;


class BaseModel extends PdoConnection implements IModel  {
	
/** @var string  */
    protected $table;
    protected $key = "id"; // primary key column name
    protected $alias;
    protected $dataRowClass;
    /** @var PDO  */
    private  $connection;
    
    public $conditions = [];
    public $bindings = [];
    public $order = '';
    public $select = '*';
    public $limit = '';
    public $offset = '';
    public $columns = [];
    
    
    
    /**
     * Constructor.
     *
     * @param PDO $connection
     * @param string $table
     * @param string $dataRowClass specify class if you need to fetch data to specific class instances
     */
    public function __construct(IConnection $connection , $table, $key = 'id' , $alias = '', $dataRowClass = null)
    {       
    	$this->connection = $connection;
        $this->table = $table;
        $this->alias = $alias;
        $this->conditions = array();
        $this->key = $key;
    }
    /**
     * Returns generated SQL.
     *
     * @return string
     */
    public function getSql()
    {
    	$where = (count($this->conditions) === 0)
            ? '' : 'WHERE ' . implode(' and ', $this->conditions);
        
        $order = (trim($this->order) === '') ? '' : ' order by ' .$this->order;
        $limit = (trim($this->limit) === '') ? '' : ' limit ' . $this->limit;
        $offset = (trim($this->offset) === '') ? '' : ' offset ' . $this->offset;
            

        $sql = "SELECT $this->select FROM $this->table $where $order $limit $offset";

        return $sql;
    }
    /**
     * Prepares a PDOStatement for execution and returns it.
     *
     * @return PDOStatement
     */
    protected function getPdoStatement()
    {
        $statement = $this->connection->dbh()->prepare($this->getSql());
        if ($this->dataRowClass !== null) {
            $statement->setFetchMode(PDO::FETCH_CLASS, $this->dataRowClass);
        } else {
            $statement->setFetchMode(PDO::FETCH_OBJ);
        }
        return $statement;
    }
    /**
     * Executes query.
     *
     * @return PDOStatement
     */
    public function execute()
    {
    	
    	try {
    		
    		
    		$stmt = $this->connection->dbh()->prepare($this->getSql());
    		$stmt->execute($this->bindings);
    		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    		    		
    	
    	} catch (PDOException $e) {
    		$this->fatal_error($e->getMessage());
    	}
    	return $row;    	
    }
	
    public function addCondition($cond)
    {
    	$this->conditions[count($this->conditions)] = $cond;    	
    }

    public function clearConditions()
    {
        $this->conditions = [];        
    }
    
    /**
     * Returns records count.
     * Executes separate SQL query to count records.
     *
     * @return int
     */
    public function count()
    {
        $query = clone $this;
        $query->select = 'count(*)';
        return (int)$query->execute();
    }
    
    
    public function loadList()
    {
    	$query = clone $this;
    	$query->select = '*';
    	return $query->execute();
    }
    
    public function loadSingle($id)
    {
    	$query = clone $this;
    	$query->select = '*';
    	
    	if (isset($this->alias) && $this->alias != '' )
          $query->addCondition(" $this->alias . $this->key = $id");
        else
          $query->addCondition(" $this->key = $id");   
    	
    	$row = $query->execute();
    	if (sizeof($row) > 0  ){
    		return  $row[0];
    	}
    	else{
    		throw  new NotFoundException(" $id Not Found ");
    	}
    }
    

    public function delete($id)
    {
    	// check if the row is found 
    	$row = $this->loadSingle($id);
    	    	
    	try {
    	
    		$stmt = $this->connection->dbh()->prepare("DELETE FROM $this->table WHERE $this->key = :id");
    		$stmt->bindParam(':'.$this->key , $id);
    		$ret = $stmt->execute();
    		    		
    	
    	} catch (PDOException $e) {
    		$this->fatal_error($e->getMessage());
    	}
    	
    	return $ret;
    	
    }
    
    public function getInsertSql($exclude_id = true ) {
    	
    	$columnNames  = "";
    	$columnParams = "";
    	
    	if ( ! sizeof($this->columns)>0 )
    		throw new NotCorrectInsertStatement("Table Columns are not defined");
    	
    	foreach ($this->columns as $key => $value) {
    		
    		// Do not bind id
    		if (!($exclude_id && $this->key == $value )){
    			$columnNames   .= ','.$value;
    			$columnParams  .= ',:'.$value;
    		}
    	}
    	
    	
    	
    	$columnNames = substr($columnNames , 1);
    	$columnParams = substr($columnParams , 1);
    	
    	
    	$sql = "INSERT INTO $this->table ($columnNames) VALUES ($columnParams)";
    	
    	return $sql;
    }
    
    public function getUpdateSql() {
    	
    	$sql          = "" ;
    	$id_name 	  = $this->key;    	
    	
    	 
    	if ( ! sizeof($this->columns)>0 )
    		throw new NotCorrectInsertStatement("Table Columns are not defined");
    		 
    		foreach ($this->columns as $key => $value) {
    
    			// Do not bind id
    			if ( $id_name != $value ){
    				$sql    .= ','.$value . ' = ' . ':'.$value;    				
    			}
    		}
    		 
    		 
    		 
    		$sql = substr($sql , 1);
    		
    		
    		$sql = " UPDATE $this->table SET $sql WHERE $id_name = :$id_name "; 
            
    		return $sql;
    }
    
    protected function bindParameter($stmt , $parameterName , $row){
    	
    	$value = $this->getParameterValue($row , $parameterName);
    	
    	if (isset($value) &&  (string) $value !== '' ) {
			$stmt->bindValue(":$parameterName", $value);			
		} else {
			$stmt->bindValue(":$parameterName", NULL);			
		}
		
		return $stmt;
    }
    
    protected function bindAllParameters($stmt , $row , $exclude_id = false ){
    	
    	
    	
    	foreach ($this->columns as $key => $columnName) {    		
    		
    		// Do not bind id 
    		if (!($exclude_id && $this->key == $columnName )){
    			$this->bindParameter($stmt , $columnName , $row);    			
    		}
    	}
    	
    	return $stmt;
    }
    
    protected function getInsertPdoStatement($row)
    {
    	$sql = $this->getInsertSql();
       
    	$stmt = $this->connection->dbh()->prepare($sql);
    	
    	$stmt = $this->bindAllParameters($stmt  , $row , true );
    	
    	return $stmt;
    }
    
    protected function getUpdatePdoStatement($row)
    {
    	$sql = $this->getUpdateSql();
    	 
    	$stmt = $this->connection->dbh()->prepare($sql);
    	 
    	$stmt = $this->bindAllParameters($stmt  , $row , false );
            
        
    	return $stmt;
    }
    
    protected function getParameterValue($row , $parameterName)
    {
    	$value = '';
    	if (is_array($row) && isset($row[$parameterName])) {    		
    			$value =  $row[$parameterName];    		
    	}
    	else if (is_object($row) && isset($row->$parameterName) ) {
    			$value = $row->$parameterName;    		
    	}
    	else 
    		$value =  '';
    	
    		
    	return $value;	
    }
    
    public function insert($row , $return_id = true ){
    	
    	$last_id = $this->getParameterValue($row , $this->key);
    	
    	try {
    		
    		$stmt = $this->getInsertPdoStatement($row , !$return_id );
    		
    		$ret = $stmt->execute();
    			
    		if ($return_id){
    			$last_id = $this->connection->dbh()->lastInsertId($this->table."_id_seq");
    		}
    	
    		
    	} catch (PDOException $e) {
    		$this->fatal_error($e->getMessage());
    	}
    	// return the last inserted id
    	return $last_id;
    	    
    }
    
    public function update($row ){
    	
    	
    	$updated = false;
    	//$last_id = $this->getParameterValue($row , $id_name);
    	 
    	try {
    		    		
    		$stmt = $this->getUpdatePdoStatement($row );
    		 
    		$ret = $stmt->execute();
    		 
    		if ($ret > 0 ){
    			$updated = true;
    		}
    		 
    
    	} catch (PDOException $e) {
    		$this->fatal_error($e->getMessage());
    	}
    	    	

        return $updated;
    }
    
    function InsertBulk($rows , $columns) {
    	try {
    		
 
    		foreach($rows as $row) {
    			//build the row to insert as a string
    			$insertrow = array();
    			//add fields one by one
    			foreach ($row as $field) {
    				$insertrow[] = str_replace("/?", "/&", pg_escape_string($field));
    			}
    			//also add static values to each row
    			$insertrow[] = pg_escape_string($profile_id);
    
    			$lines[] = "('".implode("','",$insertrow)."')";
    		}
    			
    		
    		$sql = "insert into $this->table
				(date, " . implode(",",$columns) . ") 
				VALUES ".implode(",",$lines);
    		
    		$stmt = $this->connection->dbh()->prepare($sql);
    		$stmt->execute();
    			    		
    
    	} catch (PDOException $e) {
    		$this->fatal_error($e->getMessage());
    	}
    
    	return $stmt->rowCount();
    }



    public function executeExternalStatement($sql , $params )
    {
        
        
        $stmt = $this->connection
                      ->dbh()
                      ->prepare($sql);
                
        foreach ($params as $key => $value) {   
            if (isset($value) &&  (string) $value !== '' ) {
                $stmt->bindValue(":$key", $value);            
            } else {
                $stmt->bindValue(":$key", NULL);          
            }
        }
        

        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function filterList($queryItems , $offset = 0 , $limit = 100,  $orderBy = '')
    {

        $query = clone $this;

        foreach ($query->columns as $key => $columnName) {           
            foreach ($queryItems as $itemKey => $item) {           
                if ($columnName == $item->column){
                    if ( in_array($columnName ,['id','name'] ) && $query->alias != '' )
                        $query->addCondition($query->alias . '.' . $columnName ." " . $item->operation ."'" . $item->value . "'");                 
                    else
                       $query->addCondition($columnName ." " . $item->operation ."'". $item->value ."'");                    
                }
            }            
            
        }

        $query->offset = $offset ;
        $query->limit = $limit;
        $query->order = $orderBy;


        $query->select = '*';
        return $query->execute();
    }
    
}    