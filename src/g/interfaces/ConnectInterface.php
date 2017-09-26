<?php

namespace g\interfaces;

interface ConnectInterface {

	function dbh();
	function connect();
	function close();
	
}