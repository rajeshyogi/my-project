<?php
echo "<pre>";
print_r(filter_list());



$var = "10";
$filtered = filter_var($var, FILTER_VALIDATE_FLOAT);
var_dump($filtered);
?>