<?php
// $datetime1 = new DateTime('2013-02-10 00:10:00');
// $datetime2 = new DateTime('2013-02-13 00:00:22');
// $interval = $datetime1->diff($datetime2);
// echo $interval->format('%R%a days');
?>




<?php
$datetime1 = date_create('2009-10-11');
$datetime2 = date_create('2009-10-13');
$interval = date_diff($datetime1, $datetime2);
echo $interval->format('%R%a days');
?>
