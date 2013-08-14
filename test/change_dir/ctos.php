<?php
$directory = __DIR__;
$scan = scandir($directory);

foreach($scan as $file){

	$newname = strtolower($file);
	
	rename("$directory/$file","$directory/$newname");
}
?>