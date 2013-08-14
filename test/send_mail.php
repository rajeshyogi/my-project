<?php
if(isset($_REQUEST['submit'])){
session_start();
	$name 			= $_REQUEST['name'];
	$email_add 		= $_REQUEST['email_address'];
	$phone 			= $_REQUEST['phone'];
	$country 		= $_REQUEST['country'];
	$tour_name 		= $_REQUEST['tour_name'];
	$arrival_data 	= $_REQUEST['arrival_date'];
	$dep_date 		= $_REQUEST['departure_date'];
	$travel_month 	= $_REQUEST['travel_month'];
	$travel_year 	= $_REQUEST['travle_year'];
	$no_person 		= $_REQUEST['no_person'];
	$no_child 		= $_REQUEST['no_child'];
	$intrest 		= $_REQUEST['interest'];
	$add_details 	= $_REQUEST['add_details'];
	
	$to = 'ch.agrawal1990@gmail.com';
	
	$subject = $add_details;
	
	$message = "Hello mr, this person want to contact you his/her detail's are <br/>Name : <b>$name</b>
	<br/>	Email <b>$email_add</b> 
	<br/> Phone <b>$phone</b>
	<br/> Country <b>$country</b>
	<br/> Name of The Desired Tour <b>$tour_name</b>
	<br/> Arrival Date <b>$arrival_data</b>
	<br/> Departure Date <b>$dep_date</b>
	<br/> Preferred Month and year of Travel <b>$travel_month $travel_year </b>
	<br/> Number of Persons  <b>$no_person </b> Number of Child <b>$no_child </b>
	<br/> Activity of Interest <b>$intrest</b>
	<br/> Additional Details <b>$add_details</b>";
	
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";	

	// More headers
	$headers .= "From: <'$email_add'>" . "\r\n";
	//$headers .= 'Cc: myboss@example.com' . "\r\n";
	$emails = mail($to,$subject,$message,$headers);
	if($emails){
		$_SESSION['mail_status'] = "<font color ='green'>E-mail has been sent successfully.</font>";
		header('location:form.php');
	}else{
		$_SESSION['mail_status'] = "<font color = 'red'>Some error occurred please try again.</font>";
		header('location:form.php');
	}
}
?>