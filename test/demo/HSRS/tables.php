<!-- scripts by hscripts.com-->
<?php
include "./config.php";

$dbh=mysql_connect($hostname,$username, $password)
	or die("Unable to connect to mysql");

$link = mysql_select_db($dbname,$dbh) 
	or die("Could not select database");
 
$result = mysql_query("create table jstar(id bigint(20) PRIMARY KEY auto_increment,ip varchar(25),url varchar(250),dat date,rateval int)");
if($result)
  echo "<span style='color: green; font-size: 12px;'>Your tables are created succezzfully..........</span>";
?>
<!-- scripts by hscripts.com-->