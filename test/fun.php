<?php
	function f()
	{
		function inside_f()
		{
			echo 'i am inside_f()';
		}
		echo 'i am simple f()<br>';	
	}
		//f();
		inside_f();
?>