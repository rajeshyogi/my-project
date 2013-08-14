<?php
  class test{ //example for testing class to make private and protected these are not supported in php. because we cant declare construcrot as private.
	protected function __construct(){
		print 'this is hello function';
	}
}

$obj = new test();
?>