<?php


use g\model\UserModel;
use test\g\BaseTest;


class UserModelTest extends BaseTest {

    
	public function testModel() {

		$q = new UserModel();
		
		echo $q->count();
		
		//var_dump($q->loadList());
		

		$this->assertEquals ( 2, 1 +1);
	}
	
	public function testLoadSingle() {
	
		$q = new UserModel();		
		//var_dump($q->loadSingle("2"));
	
	
		$this->assertEquals ( 2, 1 +1);
	}
	

}