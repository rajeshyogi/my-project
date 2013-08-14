<?php
require_once 'php-oop-login.php';
if(!isset($_SESSION['username'])){
                header('location:login-html.php');
            }  else {
     echo "<p align='right'>Welcome ".$_SESSION['username']."<a href='php-oop-login.php?logout=1'> logout</a>";           
}

/*
 * displya some information for user and available some functanality
 */

if(isset($_REQUEST['submit'])){
   
}

?>
<img src="<?php echo $destination .'/'.$filename;?>">

<form name ="uploaduserpic" id="uploaduserpic" method ="post" enctype="multipart/form-data">
    Choose Photo :<input type="file" name ="userpic">
    <input type="submit" name="submit" value="Upload">
</form>
 
