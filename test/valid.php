<script type="text/javascript" src="<?php echo $siteurl;?>jquery-1.7.2.min.js"></script>
<script>

////////////******  validatio for contact   *********/////////

function validate_contact(str){		
	
	if(document.frmAdd.name.value==''){
		
		$('#name_error').show();
		$('#name_error').html("Please enter the contact person name");

		document.frmAdd.name.focus();

		return false;

	}else{
		
		$('#name_error').hide();
	}
</script>

<form name="frmAdd" method="post" onSubmit="return validate_contact(this);">
    <div class="get_row">
      <label>Name<em>*</em></label>
      <input type="text" class="input_get" name="name" id="name" />
      <div id="name_error" class="error-massage"></div>
    </div>
    
<div class="get_row">
      <div id="message_error" class="error-massage"></div>
      <input type="submit" class="get_submit" name="Submit" />
    </div>
    </form>