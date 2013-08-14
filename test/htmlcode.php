
$num = 1; 

while ($num<=10) 
{ 
echo "Loop $num <br />"; 

$num = $num + 1; 
}

<span style="color:#FE7A15;font-size:140%">&#9632;</span>&nbsp;<a href="http://stackoverflow.com">stackoverflow.com</a>&nbsp; 
                    <span style="color:#FE7A15;font-size:140%">&#9632;</span>&nbsp;<a href="http://stackapps.com">api/apps</a>&nbsp; 
                    <span style="color:#FE7A15;font-size:140%">&#9632;</span>&nbsp;<a href="http://careers.stackoverflow.com">careers</a>&nbsp; 
                    <span style="color:#E8272C;font-size:140%">&#9632;</span>&nbsp;<a href="http://serverfault.com">serverfault.com</a>&nbsp; 
                    <span style="color:#00AFEF;font-size:140%">&#9632;</span>&nbsp;<a href="http://superuser.com">superuser.com</a>&nbsp; 
                    <span style="color:#969696;font-size:140%">&#9632;</span>&nbsp;<a href="http://meta.stackoverflow.com">meta</a>&nbsp; 
                    <span style="color:#46937D;font-size:140%">&#9632;</span>&nbsp;<a href="http://area51.stackexchange.com">area&nbsp;51</a>&nbsp; 
                    <span style="color:#C0D0DC;font-size:140%">&#9632;</span>&nbsp;<a href="http://webapps.stackexchange.com">webapps</a>&nbsp; 
                    <span style="color:#000000;font-size:140%">&#9632;</span>&nbsp;<a href="http://gaming.stackexchange.com">gaming</a>&nbsp; 
                    <span style="color:#dd4814;font-size:140%">&#9632;</span>&nbsp;<a href="http://askubuntu.com">ubuntu</a>&nbsp; 
                    <span style="color:#9ce4fe;font-size:140%">&#9632;</span>&nbsp;<a href="http://webmasters.stackexchange.com">webmasters</a>&nbsp; 
                    <span style="color:#cf4d3f;font-size:140%">&#9632;</span>&nbsp;<a href="http://cooking.stackexchange.com">cooking</a>&nbsp; 
                    <span style="color:#f4f28d;font-size:140%">&#9632;</span>&nbsp;<a href="http://gamedev.stackexchange.com">game development</a>&nbsp; 
                    <span style="color:#0f3559;font-size:140%">&#9632;</span>&nbsp;<a href="http://math.stackexchange.com">math</a>&nbsp; 
                    <span style="color:#f2f2f2;font-size:140%">&#9632;</span>&nbsp;<a href="http://photo.stackexchange.com">photography</a>&nbsp; 
                    <span style="color:#037187;font-size:140%">&#9632;</span>&nbsp;<a href="http://stats.stackexchange.com">stats</a>&nbsp; 
                    <span style="color:#f1e7cc;font-size:140%">&#9632;</span>&nbsp;<a href="http://tex.stackexchange.com">tex</a>&nbsp; 
                    <span style="color:#e1cdae;font-size:140%">&#9632;</span>&nbsp;<a href="http://english.stackexchange.com">english</a>&nbsp; 
                    <span style="color:#a2d9f6;font-size:140%">&#9632;</span>&nbsp;<a href="http://cstheory.stackexchange.com">theoretical cs</a>&nbsp; 
                    <span style="color:#1b3e6c;font-size:140%">&#9632;</span>&nbsp;<a href="http://programmers.stackexchange.com">programmers</a>&nbsp; 
                    <span style="color:#293a5d;font-size:140%">&#9632;</span>&nbsp;<a href="http://unix.stackexchange.com">unix</a>&nbsp;



<?php
$source = ob_get_clean(); //assign the content of the buffer to $source
echo '<pre>' .  htmlentities($source) . '</pre>'; //output $source with html entities
?> 