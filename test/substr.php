<?php
	$url = 'http://www.people-first.co.uk/wp-content/Cimy_User_Extra_Fields/HeatherZhang1983/file/Heather-Longyin-Zhang.doc';
	
	$exp = explode('/',$url);
	
	echo $finalurl = $exp[5]."/".$exp[6]."/".$exp[7];
?>