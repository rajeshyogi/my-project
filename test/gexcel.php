<?php
$host_name="localhost";
$username="root";
$password="";
$db_name="tiappsco_citiapps";

//Database Connection
$conn=mysql_connect($host_name,$username,$password);

//Database Select
mysql_select_db($db_name,$conn);

$query  = "SELECT * FROM ti_portfolio ";
$result = mysql_query($query) or die(mysql_error().'Error, query failed');
$html="";
$xml = "";
while($row = mysql_fetch_array($result))
{
        $xml .="<tr>
		<td>".$row['id']."</td>
		<td>".$row['name']."</td>
		<td>".$row['url']."</td>
		</tr>";
}
$html .= "<table border=1 style='border-color:#CCCCCC'>
		  <tr>
		  <td><b>portfolio id</b></td>
		  <td><b>portfolio name</b></td>
		  <td><b>portfolio url</b></td>
		  </tr>" . $xml . "</table>";
$fileName = 'ti_portfolio.xls';
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$fileName");
echo $html;
?>