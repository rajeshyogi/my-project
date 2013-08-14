<?php 
//echo $url = 'http://www.people-first.co.uk/wp-content/Cimy_User_Extra_Fields/Taizo%20Yamamoto/file/CVã€€10-Jun-13.doc';echo "<br>";
echo $url = 'www.people-first.co.uk/wp-content/Cimy_User_Extra_Fields/Taizo%20Yamamoto/file/';echo "<br>";
$fileNAme = 'CV 10-Jun-13.doc';echo "<br>";
echo $encFile = urlencode($fileNAme);echo "<br>";
echo $newUrl = $url.$encFile;die;
//preg_replace('/\s*/is', '', $url);
//echo preg_replace('/€€/is', '', $url);die;
    include('db.php');
    $sql = "SELECT *
            FROM users
            INNER JOIN events_heats_users
            ON users.id=events_heats_users.users_id
            WHERE users.id = 1;";
    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);
    echo "<pre>";
    print_r($row);
?>