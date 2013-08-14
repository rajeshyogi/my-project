<?php
echo "<br/>//////////////////star programme/////////////////////////////	";
	for($i=1;$i<=5;$i++){
		echo "<br/>";
		for($j=$i;$j<=5;$j++){
			echo $j;
		}
	}
	echo "<br/>//////////////////star programme/////////////////////////////	";
		for($i=1;$i<=5;$i++){
		echo "<br/>";
		for($j=1;$j<=$i;$j++){
			echo $j;
		}
	}
	echo "<br/>//////////////////star programme/////////////////////////////	";
		for($i=5;$i>=1;$i--){
		echo "<br/>";
		for($j=$i;$j>=1;$j--){
			echo $j;
		}
	}
	echo "<br/>//////////////////star programme/////////////////////////////	";
	for($i=5;$i>=1;$i--){
		echo "<br/>";
		for($j=$i;$j<=5;$j++){
			echo $j;
		}
	}
	echo "<br/>//////////////////star programme/////////////////////////////	";
	for($i=1;$i<=5;$i++){
		echo "<br/>";
		for($j=$i;$j>=1;$j--){
			echo $j;
		}
	}
	echo "<br/>//////////////////star programme/////////////////////////////<br/>	";
	for($i=0;$i<10;$i++){
	for($j=0;$j<=$i;$j++){
	   if($i%2!=0 || $i==0 || $j==1)
	   echo "*";
	   
	   }
	   echo"</br>";
	   }
	   	echo "<br/>//////////////////star programme/////////////////////////////<br/>	";
		for($i=1;$i<=5;$i++){
			for($j=5;$j>$i;$j--){
				echo "_";
			}
			for($k=$i;$k>0;$k--){
				echo $k;
			}
			
			echo '<br/>';
	}
	
	echo "<br/>//////////////////star programme/////////////////////////////<br/>	";
	
	for($i=0;$i<=5;$i++)
	{
		echo "<br/>";
		$k = 5-$i;
	for($j=0;$j<$k;$j++){
	
		if($j+1==$k)
		{
				echo "*";	
		}else
		{
	
		echo "&nbsp";
	}
	}
	}
	
	
	
	
	
	
?>