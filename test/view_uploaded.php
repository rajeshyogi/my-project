<?php
$sql_con = mysql_connect("localhost","root","");
$db_select = mysql_select_db("image-store");
if($db_select){


	$date_query = mysql_query("select distinct date from images order by date desc limit 0,3");
	while($rows = mysql_fetch_array($date_query)){
		$dates =  $rows['date'];
		echo "--------------------------------------$dates-----------------------------------------<br/><br/>";
		
		//echo "select image_name from images where date = '".$dates."' order by date desc";die;
		
		$images_query = mysql_query("select image_name from images where date = '".$dates."' order by date desc");
		while($row = mysql_fetch_array($images_query)){
		$image_name = $row['image_name']; 
		?>
		
			<img src="upload/<?php echo $image_name; ?>" height="100" width="500" /><br/><br/>
		
		<?php
		
	}}
	
}else{
echo "MYSQL ERROR PLEASE CHECK YOUR CONNECTION";
}?>
