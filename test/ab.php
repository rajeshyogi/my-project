<?php
class hello
{
		
	function asa($a=10)
	{
		print  $a;
		return $a+10;
	}
	
	function aba()
	{
		print $this->asa();
	}
}
$obj = new hello();

$obj->asa();
echo '<br/>';
$obj->aba();









?>