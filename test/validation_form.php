<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/jquery.form.js"></script> 
<script type="text/javascript"> 
$(document).ready(function(){ 
        $("#contact-form").validate({ 
    invalidHandler: function(form, validator) { 
      var errors = validator.numberOfInvalids(); 
      if (errors) { 
        var message = errors == 1 
          ? 'You missed 1 field. It has been highlighted' 
          : 'You missed ' + errors + ' fields. They have been highlighted'; 
        $("div.error span").html(message); 
        $("div.error").show(); 
      } else { 
        $("div.error").hide(); 
      } 
    } 
         }) 
        
        $("#contact-form").validate({ 
             submitHandler: function(form) { 
                $(form).ajaxSubmit(); 
             } 
        }) 

}); 
</script> 






<div class="sub-content">  
                 <h1>
              Enquiry Form
          </h1>  
       <div id="form-container">       
         <form  id="contact-form" method="post" action="submit.php">    
         <!-- The form, sent to submit.php -->
              <div>
                <label for="name">*Name:</label>
                <input  type="text" class="required" name="name" id="name" tabindex="1" value="" />
              </div>
              <div>
                <label for="number">*Contact Number:</label>
                    <input type="text" class="required number" name="number" id="number" tabindex="2" value="" />
              </div>         
              <div>
                <label for="email">*E-mail</label>
                <input type="text" class="required email" name="email" id="email" tabindex="3" value="" /> 
              </div>
              <div>
              <label for="subject">*Enquiry Type</label>
              <select name="Enquiry Type" class="required" id="enquiry" tabindex="4">
                <option selected="selected" value="">Please select..</option>
                <option value="Website Design &amp; Development">Website Design &amp; Development</option>
                <option value="Online Marketing">Online Marketing</option>
                <option value="Graphic Design">Graphic Design</option>
                <option value="Saying Hello">Saying hello</option>
                <option value="Working with us">Working with us</option>
                <option value="Other">Other</option>
              </select>
              </div>          
              <div>
                <label for="message">*Message</label>
                <textarea  name="message" id="message" class="required" cols="35" rows="5" tabindex="5" value=""></textarea>
              </div>
              <div>
                <input type="submit" name="submit" id="button" value="Submit" />
              </div>
          </form> 
        </div>
        <div class="error">     
          <span></span>
        </div> 
        <p class="small-port">
              As we are generally quite busy we will do our best to answer you within 48 hours.
        </p> 
      </div>
    </div>