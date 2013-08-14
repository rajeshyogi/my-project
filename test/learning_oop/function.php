<?php
	function db_connection()
	{
		global $hostname,$root,$password,$dbname;
		mysql_connect($hostname,$root,$password);
		mysql_select_db($dbname);
	}
	
	function select_city($countryid)
	{
		$city_result = mysql_query("select city from city where countryid='".$countryid."'");
		while($city = mysql_fetch_array($city_result))
		{
			$ct[]['city'] = $city['city'];
		}
		return $ct;
	}
	
	
	function select_city_country()
	{
		$result = mysql_query("select * from city inner join country");
		$i = 0;
		while($row = mysql_fetch_assoc($result))
		{
			$a[$i]['city'] = $row['city'];
			$a[$i]['country'] = $row['country'];
			$i++;
		}
		return $a;
	}
	
?>