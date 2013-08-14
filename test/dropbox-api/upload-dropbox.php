<?php
require_once "dropbox-sdk/Dropbox/autoload.php";
// if(file_exists('config.json')){
	// print 'yessssssssssssss';
// }else{
	// print 'nopeeeessssss';
// }die;
$appInfo = Dropbox\AuthInfo::loadFromJsonFile("config.json");
$f = fopen("working-draft.txt", "rb");
$result = $dbxClient->uploadFile("/working-draft.txt", dbx\WriteMode::add(), $f);
fclose($f);
print_r($result);
?>