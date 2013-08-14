<?php
	setcookie('user','rajesh',time()+5);
	
	print_R($_COOKIE);
	if(isset($_COOKIE["user"])){
		echo "WELCOME ".$_COOKIE["user"];
	}else{
		echo "WELCOME GUEST";
	}
	
	
?>