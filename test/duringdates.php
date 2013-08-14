<?php
$dateFormat="Y-m-d";
$date1=Date($dateFormat);
 echo "<br>First date : ".$date1."<br>"; 
   $date2="2013-05-20";
 echo "Second date : ".$date2."<br>"; 
$days = (strtotime($date1) - strtotime($date2)) / (60 * 60 * 24);
echo "Number of days : ".floor($days);
?>
   
