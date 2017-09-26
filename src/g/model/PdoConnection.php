<?php
namespace g\model;

use g\interfaces\ConnectInterface as IConnection;

class PdoConnection {
	
	
	private $connection;
	
	public function __construct(IConnection $connection)
	{		
		$this->connection = $connection;
	}
	
	
	function connect() {
		$this->connection->connect();
	}
	
	function close() {
		$this->connection->close();
	}
	

	protected function fatal_error($msg) {
		if ( ($GLOBALS['debug'] == TRUE) || (!isset($_SERVER['HTTP_HOST'])) ) {
			echo "<pre>Error!: $msg\n";
			$bt = debug_backtrace();
			foreach ($bt as $line) {
				$args = var_export($line['args'], true);
				echo "{$line['function']}($args) at {$line['file']}:{$line['line']}\n";
			}
			echo "</pre>\n";		
			exit(1);
		} else {
			//backtrace
			$bt = debug_backtrace();
			$backtrace = '';
			foreach ($bt as $line) {
				$args = var_export($line['args'], true);
				$backtrace .= "{$line['function']}($args) at {$line['file']}:{$line['line']}\n";
			}
						
			exit(1);
		}
	}
}

?>