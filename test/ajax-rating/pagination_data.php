<?php
include('config.php');

$per_page = 3; 

if($_GET)
{
$page=$_GET['page'];
}



//get table contents
$start = ($page-1)*$per_page;
$sql = "select * from messages order by msg_id limit $start,$per_page";
$rsd = mysql_query($sql);
?>


	<table width="800px">
		
		<?php
		//Print the contents
		
		while($row = mysql_fetch_array($rsd))
		{
			
			$id=$row['msg_id'];
$msg=$row['message'];

		?>
		<tr><td style="color:#B2b2b2; padding-left:4px" width="30px"><?php echo $id; ?></td><td><?php echo $msg; ?></td></tr>
		<?php
		} //while
		?>
	</table>

