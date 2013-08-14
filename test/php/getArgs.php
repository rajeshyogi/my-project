<?php
	function SomeFunction($noDefault, $Default = 'SomeDefault') 
	{
		print_r(func_get_args());
	}
$noDefault = 'Varun';
SomeFunction($noDefault);
?>