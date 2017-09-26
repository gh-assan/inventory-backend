<?php


use g\model\UserModel;
use g\service\UserService;
use g\service\BcryptService;
use test\g\BaseTest;


class BcryptServiceTest extends BaseTest {

	public function testValidate() {
		
		$m = new UserModel();
		$B = new BcryptService();
		$U = new UserService($m,$B);
	
		
		$this->assertNotEquals ( $U->validate("test_admin_user@g.de","Aibobe7u") , false);
	}


}