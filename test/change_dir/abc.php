<?php
echo $directory = __DIR__;

     $files = scandir($directory);
	
    foreach($files as $key=>$name){
		
    $oldName = $name;
	
    $newName = strtolower($name);
	
    rename("$directory/$oldName","$directory/$newName");
    }
?>