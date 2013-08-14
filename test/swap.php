<?php

$x = 2;
$y = 5;
$x = $x+$y;	//here is $x value = 7

echo '$y = '.$y = $x-$y.'<br/>';	//7-5 = 2

echo '$x = '.$x = $x-$y;	//7-2 = 5

echo $directory = __DIR__;
die;
$files = scandir($directory);

foreach ($files as $key => $name) {

    $oldName = $name;

    $newName = strtolower($name);

    rename("$directory/$oldName", "$directory/$newName");
}


function tennis_menu_menu(){
$items['tennis_menu/%/%'] = array(
'title' => 'putname',
 'page callback' => 'tennis_mod',
 'access arguments' => array(1, 2),
 'access callback' => TRUE,
 'type' => MENU_CALLBACK,
);
return $items;
}

function tennis_mod($cid, $uid) {
$update = db_update('test_tennis')
        ->fields(array(
            'title' => 'hello how r you im ',
        ))
        ->condition('cid', $cid, '=')
        ->condition('uid', $uid, '=')
        ->execute();

drupal_goto('http://localhost/drupal-custome/tennis_menu/10/20');
}

?>