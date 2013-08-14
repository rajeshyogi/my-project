<?php
$ms='yyyy';
//$string = preg_replace("[^0-9]", "",$ms);
//echo $string;
if(is_numeric($ms)){
	echo "NUMERIC";
}else{
	echo "STRING";
}



//programme to check string or numeric in given $ms.
if(!preg_replace("/[^0-9]/","",$ms)){
	echo "string hai";
}else{
	echo "numeric b hia";
}
//echo print('hello');


//programme to reverse string without reverse function in php
$str = "RAJESH";
$len = strlen($str);
for($i=$len-1; $i>=0; $i--)
{
echo $str[$i];
}

// interface Ia{
	// function op();
// }

 // class a {
	// final function aaa(){
		// echo 'aaa of a';
	// }
// }

// class b extends a {
	// function aaa(){
		// echo 'aaa of b';
	// }
// }

// class c extends a implements Ia{
	// function aaa(){
		
		// echo 'aaa of c';
	// }
	// function op(){
		
	// }
// }


// $obj = new c();
// $obj->aaa();
?>