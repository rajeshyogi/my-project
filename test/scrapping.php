<?php
//$url = "http://localhost/test/menu.php";

//$output = file_get_contents($url);

//echo $output;

?>


 <?php 
 $data = file_get_contents('http://www.google.co.in/');
 $regex = '/Page 1 of (.+?) results/';
 preg_match($regex,$data,$match);
 var_dump($match); 
 ///echo $match[1];
 ?>