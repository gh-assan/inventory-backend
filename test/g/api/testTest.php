<?php



use g\api\TestApi;
use test\g\BaseTest;


class ApiTest extends BaseTest {

	
	public function testAddition() {
		$this->assertEquals ( 2, 1 +1);
	}

    
	public function testModel() {

		$q = new TestApi();
		/*
		echo $q->count();

		var_dump($q->listAll());
		*/

		$this->assertEquals ( 2, 1 +1);
	}
	

}