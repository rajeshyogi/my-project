<html>
	<head>
		<title>Rajesh's Ajax dropdown code</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<script src="jquery-1.7.2.min.js"></script>
		
	</head>
			<script>
				$(document).ready(function() {
					$("#country").change(function(){
							$.ajax({
								url: 'fq.php?country='+this.value,
								success: function(data) {
									$('#citydiv').html(data);
								}
							});
						});
					
				});
				
			</script>
	<body>

		<form method="post" action="" name="form1">
			<table width="60%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="150">Country</td>
					<td  width="150">
						<select name="country" id="country">
							<option value="">Select one</option>
							<option value="1">thetigroup</option>
							<option value="2">tiapps</option>
						</select>
					</td>
				</tr>
				<tr style="">
					<td>City</td>
					<td >
						<div id="citydiv">
							
						</div>
					</td>
				</tr>
			</table>
		</form>
		
	</body>
</html>
