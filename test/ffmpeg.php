<?php
	$ffmpeg =’C:\ffmpeg\bin\ffmpeg’; // path of installed ffmpeg
	$videofile = “test.wmv”;
	$imagefile =”thumbnail.jpg”;
	$size = ’200×120';
	$interval =2; // At what time the screenshot to be taken after video is started
	$cmd = “$ffmpeg -i $videofile -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y -s $size $imagefile 2>&1“;
	shell_exec($cmd);
?>