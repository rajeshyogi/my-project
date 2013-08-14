<?php

$words = preg_split('//', 'abcdefghijklmnopqrstuvwxyz', -1);
shuffle($words);


foreach ($words as $word) {
    //echo $word . '<br />';
}
?>



<?php
$numbers = range('a','z');
shuffle($numbers);
foreach ($numbers as $number) {
    echo "$number ";
}
?>
