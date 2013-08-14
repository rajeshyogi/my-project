<?php
	$today =  date('d-m-Y');
	
	$comp_Date = "25-10-2012";
	
	
	if($today < $comp_Date){
		echo "correct";
	}else{
		echo "wrong";
	}
?>