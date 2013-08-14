
<?php
// function itrate(){
	// yield rajesh;
	// yield  kumar;
	// yield  yogi;
// }
// itrate();
// itrate();
// itrate();

// function addone(&$var)
// {
   // print $var++;
// }
// $num=1;

// addone($num);
// addone($num);
// addone($num);
// addone($num);
// addone($num);
// addone($num);
// addone($num);
// addone($num);
// addone($num);
// addone($num);


echo memory_get_usage() . "\n"; // 36640

$a = str_repeat("Hello", 4242);

echo memory_get_usage() . "\n"; // 57960

unset($a);

echo memory_get_usage() . "\n"; // 36744
?>
