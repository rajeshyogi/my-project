<!-- Welcome to the scripts database of HIOX INDIA      -->
<!-- This tool is developed and a copyright             -->
<!-- product of HIOX INDIA.			        -->
<!-- For more information visit http://www.hscripts.com -->

<br>

<link href="<?php echo $hm2;?>/rating.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="<?php echo $hm2;?>/jquery.js"></script>
<script type='text/javascript'>
$(document).ready(function(){
$('.star a').hover(function(){
      var uid = this.id;
      switch(uid){
        case '1':
          $('#rateit').css({visibility: "visible", color: "red","font-size": "12", "font-family":"Arial"});
          $('#rateit').html('&nbsp;Poor');
          break;
        case '2':
          $('#rateit').css({visibility: "visible", color: "#b8860b","font-size": "12", "font-family":"Arial"});
          $('#rateit').html('&nbsp;Fair');
          break;
        case '3':
          $('#rateit').css({visibility: "visible", color: "purple","font-size": "12", "font-family":"Arial"});
          $('#rateit').html('&nbsp;Good');
          break;
        case '4':
          $('#rateit').css({visibility: "visible", color: "blue","font-size": "12", "font-family":"Arial"});
          $('#rateit').html('&nbsp;Very Good');
        case '5':
          $('#rateit').css({visibility: "visible", color: "green","font-size": "12", "font-family":"Arial"});
          $('#rateit').html('&nbsp;Excellent');                         
    }
    });
    
   $('.star a').mouseout(function() {
     var uid = this.id;
     $('#rateit').css({visibility: "hidden"});
     for(var x=1;x<=uid;x++){
        $('#star'+x).css('background-image', 'url("./HSRS/images/star.gif")');
     }
   });

  $('a').click(function(){
        var val = $(this).text();
		//alert(val);
        $.get('./HSRS/addrating.php','rating=' + val,function(result){
          if(result != "not added"){
	    var sp = result.split("#");
            var ff = "[ "+sp[0]+" ]";
            var dispstars = sp[1];
            $("#final").html(dispstars);
            $("#strimg").html(ff);
            $('#res').css({opacity: 0.0, visibility: "visible"});
          }else if(result == "not added"){
            var already = ("Your Rating Is Already Present");
            $('#res').css({opacity: 0.0, visibility: "visible"});
            $("#already").css({visibility: "visible", "font-size":"12px",color: "red","padding-left":"15px"});
            $("#already").fadeIn(100);
            $("#already").html(already);
            $("#already").fadeOut(5000);
          }         
       });
    });

   }); 
  
</script>
<?php
  $start = $_GET['begin'];
  if($start == "")
	$start = 0;
  $url = $_SERVER['SCRIPT_NAME'];
  $host = $_SERVER['SERVER_NAME'];
  $ser = "http://$host";	
  $url1 = $_SERVER['argv'];
  $sss = count($url1);
  $serpath = $ser.$url;

if($sss >= 1)
  {
     $argas = $url1[0];
     $url="$url?$argas";
  }
  $url= $ser.$url;

  include "$hm/config.php";

  $link = mysql_connect($hostname, $username,$password);
  if($link)
  {
	$dbcon = mysql_select_db($dbname,$link);
  }
    $qur1 = "select count(*) as dd, avg(rateval) as xx from $tablename where url='$url' group by url";
    $result1 = mysql_query($qur1,$link);
  if($line = @mysql_fetch_array($result1, MYSQL_ASSOC))
  {
	$count = $line['dd'];
	$rateval = $line['xx'];
  }

?>

				