<?php
require_once 'php-oop-login.php';

if(isset($_REQUEST['submit'])){
    $username = mysql_real_escape_string($_REQUEST['username']);
    $password = mysql_real_escape_string($_REQUEST['password']);
    $obj = new user();
    $obj->login_system($username,$password);
}
if(isset($_SESSION['username'])){
    header('location:user.php');
}
?>

<form name="login" id="login" method = "post">
    Username : <input type='text' name="username"><br/>
    Password : <input type='text' name="password"><br/>
               <input type="submit" name="submit" value="Log In">
</form>