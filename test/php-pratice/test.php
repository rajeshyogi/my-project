<?php
// $filename = 'file.txt';
// $file = file_get_contents($filename);
// $file .= 'this file is created by rajesh yogi';
// file_put_contents($filename,$file);

// class trick
// {
      // function doit()
      // {
                // echo __FUNCTION__;
      // }
      // function doitagain()
      // {
                // echo __METHOD__;
      // }
// }
// $obj=new trick();
//$obj->doit();

// $obj->doitagain();



// $foo = 'Bob';              // Assign the value 'Bob' to $foo
// $bar = &$foo;              // Reference $foo via $bar.
// $bar = "My name is $bar";  // Alter $bar...
// echo $bar;
// echo $foo;                 // $foo is altered too.

// $a = 'Hello';
// $$a = 'world';
// echo "$a ${$a}";


// $arr = array('one', 'two', 'three', 'four', 'stop', 'five');
// while (list(, $val) = each($arr)) 
// {

    // if ($val == 'stop') {
        // break;    /* You could also write 'break 1;' here. */
    // }
    // echo "$val<br />\n";
// }

$arr = array('one' => '1', 'two' => '2', 'three' => '3', 'four' => '4', 'stop' => '0', 'five' => '5');
// echo '<pre>';
// var_dump($arr);
while(list($key,$val) = each($arr)){
	echo $key."=>".$val;
}
?>
