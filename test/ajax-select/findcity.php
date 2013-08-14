<?php 
	$country=$_REQUEST['country'];
	$link = mysql_connect('localhost', 'root', ''); //changet the configuration in required
	if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
	mysql_select_db('db_ajax');
	$query="select city from city where countryid=$country";
	$result=mysql_query($query);

	?>
	<?php 
		$output = "";
		$output .= '<select name="city"><option>Select City</option>'; ?>
	
	<?php 
			while($row=mysql_fetch_array($result)) {
				$output .= "<option value>".$row['city']."</option>";
			}
			
			$output .= "</select>";
			

			exit($output);
	?>