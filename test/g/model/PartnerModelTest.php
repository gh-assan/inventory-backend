<?php


use g\model\PartnerModel;
use test\g\BaseTest;


class PartnerModelTest extends BaseTest {

	
	public function testAddition() {
		$this->assertEquals ( 2, 1 +1);
	}

    
	public function testModel() {

		$q = new PartnerModel();
		
		echo $q->count();
		
		//var_dump($q->loadList());
		

		$this->assertEquals ( 2, 1 +1);
	}
	
	public function testInsertModel() {
	
		$q = new PartnerModel();
		
		$row = [];
		
		$row['id'] = 1001;
		$row['account_manager'] = '2';
		$row['name'] = 'name 2';
		$row['is_active'] = 'false';
		
		$q->insert($row);
		
		$this->assertEquals ( 2, 1 +1);
	}
	

}