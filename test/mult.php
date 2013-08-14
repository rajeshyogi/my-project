<form name='aa' method='post'>
	<input type='checkbox' name='1[]' value='aaa'>aaa<br/>
	<input type='checkbox' name='1[]' value='bbb'>bbb<br/>
	
	<input type = 'submit' name = 'submit'>
</form>

<?php
	print_r($_REQUEST['1']);
?>