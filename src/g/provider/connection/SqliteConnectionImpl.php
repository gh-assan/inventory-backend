<?php

namespace g\provider\connection;

use g\interfaces\ConnectInterface as IConnection;
use PDO;

class SqliteConnectionImpl implements IConnection  {
	
	static $dbh = false;
	
		
	function connect() {
	
		if (!self::$dbh) {
	
			try {
					
				self::$dbh = new PDO('sqlite::memory:');	
				self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$db = file_get_contents(__DIR__.'/resource/db.sql', true);
				self::$dbh->exec($db);
				
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