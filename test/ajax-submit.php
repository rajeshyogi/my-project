<html>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#form').submit(function(){
		
			$.post('data.php', $(this).serialize(), function(data){
				$('#content').html(data);
			});				
			return false;
		});
	});
	</script>
</head>
<body>

<form id='form'>
Name : <input type="text" name="urname"><br />
Birthplace : <input type="text" name="urbirth"><br />
<input type="submit" name="submit" value="Submit">
</form>

<div id="content"> <!--result shown here...--> </div>
</body>
</html>
