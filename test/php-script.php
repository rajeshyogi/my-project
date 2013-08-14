<?php
$phrase = "I love PHP";
if(preg_match("/I/", $phrase)) :
  echo "The expression matches";
else:
	echo 'not match';
endif;
?>