<?php


use g\service\PartnerService;
use g\model\PartnerModel;
use test\g\BaseTest;


class PartnerServiceTest extends BaseTest {

	
	public function testAddition() {
		$this->assertEquals ( 2, 1 +1);
	}

    
	public function testModel() {
		
		$m = new PartnerModel();
		$q = new PartnerService($m);
		
		//echo $q->count();
		
		//ar_dump($q->loadList());
		

		$this->assertEquals ( 2, 1 +1);
	}
	

}