<?php
$page = $_REQUEST['page'];


	
	$next = $page+1;
	$prev = $page-1;
	
	$limit = 2;
	
	
	
		$link = mysql_connect('localhost', 'root', ''); //changet the configuration in required
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
	mysql_select_db('db_ajax');
	
	
	if($page)
		{ 

		
			$start = ($page - 1) * $limit;
			
			$query="select city from city LIMIT $page,$start";
	
			$result=mysql_query($query);
			
			$nrow =  mysql_num_rows($result);
		}	
		else
		{
			$query="select city from city";
	
			$result=mysql_query($query);
			
			$start = 0;
			
			$nrows =  mysql_num_rows($result);
		}



	
	
	
	
		for ($j=1;$j<=$nrows;$j++)
		{	
			$row = mysql_fetch_assoc($result);
			echo $row['city']."<br/>";
		}
		
		//echo $nrows;
		if(isset($page))
		{
		
		
		
		if($nrows > $limit)
				{
					echo  "<a href='$_SERVER[PHP_SELF]?page=$next'>Next</a>";
				}
		
			}
		
	


?>