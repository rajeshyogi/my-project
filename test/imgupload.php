<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="upload">
<input type="submit" value="upload" name="upload">
</form>
<a href="view_uploaded.php">View uploaded image</a>
<?php
$sql_con = mysql_connect("localhost","root","");
$db_select = mysql_select_db("image-store");

if(isset($_REQUEST['upload'])){
	$tmp_name = $_FILES['upload']['tmp_name'];
	
	$image_name = $_FILES['upload']['name'];
	
	$upload_status = move_uploaded_file($tmp_name,"upload/$image_name");
	
	if($upload_status){
			echo "<font color='green'>image upload successfully<font>";
	}else{
	
			echo "<font color='red'>please browse image<font>"; 
	}
	
	
	$date = date('Y-m-d');
	
	$image_insert_query = mysql_query("insert into images (image_name,date)values('$image_name','$date')");

}
?>