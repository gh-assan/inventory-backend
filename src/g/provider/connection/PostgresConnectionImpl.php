<?php

namespace g\provider\connection;

use g\interfaces\ConnectInterface as IConnection;
use PDO;

class PostgresConnectionImpl implements IConnection  {
	
	static $dbh = false;
	
	function  getHost(){
		return '127.0.0.1';
	}
	
	function  getPort(){
		return '5432';
	}
	
	function  getUser(){
		return 'postgres';
	}
	
	function  getPassword(){
		return '100';
	}
	
	function  getDbName(){
		return 'waleed';
	}
	
	public function __construct() {
		self::connect();
	}
	
	function connect() {
	
		if (!self::$dbh) {
	
			try {
					
				self::$dbh = new PDO("pgsql:host={$this->getHost()};port={$this->getPort()};dbname={$this->getDbName()}",$this->getUser(), $this->getPassword());
	
				self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
			} catch (PDOException $e) {
				return false;
			}
	
		}
	
		return true;
	}
	
	function close() {
		self::$dbh = null;
	}
	
	function  dbh(){
		if (!self::$dbh){
			$this->connect();
		}
		
		return self::$dbh;
	}
}