<?php
session_start();
class user{
        function __construct() {
            $this->open_connection();
            
        }
        
        function open_connection(){
            $this->connection = mysql_connect("localhost","root","");
            if(!$this->connection){
                die('error while opening connection'. mysql_error());
            }else{
                $db_select = mysql_select_db('test',  $this->connection);
                if(!$db_select){
                    die('error while selecting database'.mysql_error());
                }
            }
         }


        function login_system($username,$password){
           
            $result = mysql_query("select * from login where username='".$username."' and password = '".$password."'");
            $numrows = mysql_num_rows($result);
            if($username !='' && $password !=""){
                if($numrows != 0){
                   $_SESSION['username'] = $username;
                                       
                }  else {
                    echo 'username or password not match';
                }
            }else {
                echo 'please fill your username and password';
            }
        }
        
        function logout(){
          session_destroy();
          header('location:login-html.php');
        }
}

if(isset($_GET['logout']) == 1){
    $obj = new user();
    $obj->logout();
  }
?>