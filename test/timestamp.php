<?php
	$curent_time_stamp = new DateTime();
	$curent_time_stamp->getTimestamp();
	echo "<pre>";
	print_r($curent_time_stamp);
?>



<?php
$date = new DateTime(null, new DateTimeZone('Europe/London'));
$tz = $date->getTimezone();
echo $tz->getName();
?>
