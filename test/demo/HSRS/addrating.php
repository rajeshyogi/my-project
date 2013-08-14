<?php
error_reporting(0);
include "./config.php";
$ser=$_SERVER['HTTP_HOST'];
$ref=$_SERVER['HTTP_REFERER'];

$host= parse_url($ref);

$rateval = $_GET['rating'];
$url = $ref;
$ipadd = $_SERVER['REMOTE_ADDR']; 
$dat = date('y-m-d');
$link = mysql_connect($hostname, $username,$password);
if($link)
{	
	$dbcon = mysql_select_db($dbname,$link);
}

$res  = mysql_query("select url from $tablename where ip='$ipadd' && url='$url'");
$res1  = mysql_query("select * from $tablename where url='$url'");
$dd = mysql_fetch_array($res,MYSQL_BOTH);
$val = $dd[0];
$num_rows = mysql_num_rows($res1);
if(!$val && $ser == $host[host])
{
    $result = mysql_query("insert into $tablename values(NULL,'$ipadd','$url','$dat','$rateval')",$link);
    echo ($num_rows+1)."#";
    echo "<span id=final>";
    for($i=1;$i<=5;$i++)
    {
      if($rateval>=1)
      {
		    echo "<img src=\"./HSRS/images/star2.gif\" align=absmiddle alt='star rating'>";
        $rateval=$rateval-1;
	    }
	    else if($rateval>=0.5)
	    {
 		   echo "<img src=\"./HSRS/images/star3.gif\" align=absmiddle alt='star rating'>";
		   $rateval=$rateval-1;
	    }
 	    else if ($rateval<0.5 && $rateval>0)
	    {
		    echo "<img src=\"./HSRS/images/star1.gif\" align=absmiddle alt='star rating'>";
		    $rateval=$rateval-1;
	    }
	    else if($rateval<=0)
	    {
		    echo "<img src=\"./HSRS/images/star1.gif\" align=absmiddle alt='star rating'>";
	    }
    }
   echo "</span>&nbsp;&nbsp;";	     
}
else
{
    echo "not added";
}
?>