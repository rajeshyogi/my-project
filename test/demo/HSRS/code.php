
<!-- Welcome to the scripts database of HIOX INDIA      -->
<!-- This tool is developed and a copyright             -->
<!-- product of HIOX INDIA.			        -->
<!-- For more information visit http://www.hscripts.com -->

<html>
  <head>
     <style>
        .ta{background-color: ffff44;}
        .rad{color:red; font-weight:bold; background-color: ffff44;}
        .head{font-size: 22px; color: red; font-family: verdana, arial, san-serif;}
        .links{font-size: 13px; color: white; font-family: verdana, arial, san-serif; text-decoration:none;}
        .maintext{font-size: 13px; color: #fefefe; font-family: verdana, arial, san-serif; padding:20px;}
     </style>
  </head>

  <body style="margin: 0px;">
       <table width=100% height=100% bgcolor=#dfdfdf cellpadding=0 cellspacing=0 align=left>
           <tr>
                <td align=center class=head>
                          HIOX Star Rating System<br><hr>
                </td>
           </tr>
           <tr>
                <td align=center>
                      Copy the below code in to the pages where you want HSRS (HIOX Star Rating System)<br><br>
                                           <table width=400 height=250 align=center bgcolor=white class=maintext>
                                                 <tr>
                                                     <td style="color: green; font-size: 13px;">
                                                          <?php
                                                             $url = $_SERVER['SCRIPT_FILENAME'];
                                                             $pp = strrpos($url,"/");
                                                             $url = substr($url,0,$pp);
                                                             $ura = $_SERVER['SCRIPT_NAME'];
                                                             $host = $_SERVER['SERVER_NAME'];
                                                             $ser = "http://$host";
                                                             $ura= $ser.$ura; 
                                                             $pp1 = strrpos($ura,"/");
                                                             $ura = substr($ura,0,$pp1);

                                                             echo "&lt?php<br>
                                                             $"."hm = \"$url\";<br>
                                                             $"."hm2 = \"$ura\";<br>
                                                             include \"$"."hm/addcode.php\";<br>
                                                             ?&gt;";
                                                          ?>

                                                      </td>
                                                  </tr>
                                            </table>


                                        </div>
               </td>
           </tr>
<!-- content row -->

           <tr>
               <td width=100% align=right>
                     a product by &copy; <a href="http://www.hscripts.com" 
                     style="font-size: 14px; color: 347777; text-decoration:none;">hscripts.com</a>
                     &nbsp; &nbsp; &nbsp; &nbsp;
               </td>
           </tr>
      </table>
  </body>
</html>

<!-- Welcome to the scripts database of HIOX INDIA      -->
<!-- This tool is developed and a copyright             -->
<!-- product of HIOX INDIA.				-->
<!-- For more information visit http://www.hscripts.com -->
