<?php
include("function.php");
	$hostname = "localhost";
	$root = "root";
	$password = "";
	$dbname = "db_ajax";
	
	db_connection();
	
	$countryid = 1;
	$ct_record = select_city($countryid);
	
	foreach($ct_record as $record){
		echo $record['city']."<br/>";
	}

	$city_country_result = select_city_country();

	foreach($city_country_result as $result)
	{
		echo $result['city']."<br/>";
		echo $result['country'];
	}
?>