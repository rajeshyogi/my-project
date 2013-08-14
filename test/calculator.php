<?php
require_once('../../php/pear/PHPUnit/Extensions/SeleniumTestCase.php');

class Calculator extends PHPUnit_Extensions_SeleniumTestCase
{

	function setUp(){
		$this->setBrowser("*firefox");
		
		$this->setBrowserUrl("http://login.trumin.com/event/1");
	  }
	//All the functions here must start with test* only then the tests are executed
	  function testMyTest(){
		$this->open("/");
	}
}
?>
