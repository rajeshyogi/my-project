<?php session_start();?>
<html>
<head>
<script type = 'text/javascript'>
	 function formReset(){
		document.getElementById("inqform").reset();
	 }
</script>
</head>
<body>
<p>
<?php
// error and success message print by session
	if(isset($_SESSION['mail_status'])){
		echo $_SESSION['mail_status'];
		unset($_SESSION['mail_status']);
	}
?>
</p>
<form action="send_mail.php" method="POST" name ='inqform' id ='inqform'>
                   <table cellpadding="5" cellspacing="5" border="0" width="100%">
                      <tr>
                         <td class="enquiry_Tital" colspan="3">Contact Information</td>
                      </tr>
                  
                    <tr>
                      <td width="29%" valign="middle" align="right"><strong class="font11">Your Name</strong></td>
                      <td>:</td>
                      <td valign="middle" align="left"><input type="text" size="40" class="input2" id="name" name="name"></td>
                   </tr>
         
            <tr>
            <td valign="middle" align="right"><strong class="font11">Email</strong></td>
            <td>:</td>
            <td valign="middle" align="left"><input type="text" size="40" class="input2" id="email" name="email_address"></td>
          </tr>
          
          <tr>
            <td valign="middle" align="right"><strong class="font11">Phone</strong> </td>
            <td>:</td>
            <td valign="middle" align="left"><input type="text" size="40" class="input2" id="phone" name="phone"></td>
          </tr>
          
          <tr>
            <td valign="middle" align="right"><strong class="font11">Country </strong></td>
            <td>:</td>
            <td valign="middle" align="left"><select style="width:255px;" class="input2" size="0" id="country" name="country">
                <option selected="" value="">Select Country</option>
                <option value="Albania">Albania</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Belgium">Belgium</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia">Bosnia</option>
                <option value="Brazil">Brazil</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Central America">Central America</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Colombia">Colombia</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Croatia">Croatia</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="Estonia">Estonia</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="Greece">Greece</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Italy">Italy</option>
                <option value="Japan">Japan</option>
                <option value="Jordan">Jordan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Latin America">Latin America</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macedonia">Macedonia</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Mexico">Mexico</option>
                <option value="Netherlands">Netherlands</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Palestine">Palestine</option>
                <option value="Panama">Panama</option>
                <option value="Peru">Peru</option>
                <option value="Pharos Islands">Pharos Islands</option>
                <option value="Philippines">Philippines</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Romania">Romania</option>
                <option value="Russia">Russia</option>
                <option value="Salvador">Salvador</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Serbia &amp; Montenegro">Serbia &amp; Montenegro</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="South Korea">South Korea</option>
                <option value="Spain">Spain</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syria">Syria</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Tanzania">Tanzania</option>
                <option value="Thailand">Thailand</option>
                <option value="Turkey">Turkey</option>
                <option value="UAE">UAE</option>
                <option value="Uganda">Uganda</option>
                <option value="UK">UK</option>
                <option value="UKraine">UKraine</option>
                <option value="Uruguay">Uruguay</option>
                <option value="USA">USA</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Vietnam">Vietnam</option>
                <option value="Yugoslavia">Yugoslavia</option>
              </select></td>
          </tr>
         
          <tr>
            <td align="right"><strong class="font11">Name of The Desired Tour</strong></td>
            <td>:</td>
            <td align="left"><input type="text" id="tname" name="tour_name" class="input2"></td>
          </tr>
         
         
           <tr> 
            <td align="right">Arrival Date </td>
             <td >:</td>
             <td >&nbsp;<input type="text" id="txtadate" name="arrival_date"></td>
            </tr>
         
          <tr> 
            <td align="right" >Departure Date</td>
             <td >:</td>
             <td >&nbsp;<input type="text" id="txtadate" name="departure_date"></td>
            </tr>
         
         
         
          <tr>
            <td valign="middle" align="right"><strong class="font11">Preferred Month of Travel  </strong></td>
            <td>:</td>
            <td valign="middle" align="left"><select style="width:125px;" class="input" id="month" name="travel_month">
                <option value="Month" selected="selected">Month</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option class="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
              </select>
              <select style="width:125px;" class="input" id="year" name="travle_year">
                <option>2013</option>
                <option>2014</option>
                <option>2015</option>
                <option>2016</option>
              </select>            </td>
          </tr>
         
          <tr>
            <td valign="middle" align="right"><strong class="font11">Number of Persons  </strong></td>
            <td>:</td>
            <td valign="middle" align="left"><select style="width:125px;" class="input" id="adult" name="no_person">
                <option value="Adults">Adults</option>
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>Group</option>
              </select>
              <select style="width:125px;" class="input" id="child" name="no_child">
                <option selected="selected">Child</option>
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>More</option>
              </select>            </td>
          </tr>
          
         
         
          <tr>
            <td valign="middle" align="right"><strong class="font11">Activity of Interest</strong></td>
            <td>:</td>
            <td valign="middle" align="left"><select style="width:255px;" class="input input2" id="interest" name="interest">
                <option>Leisure</option>
                <option>Honeymoon</option>
                <option>Culture</option>
                <option>Adventure</option>
                <option>Wildlife</option>
                <option>Other</option>
              </select></td>
          </tr>
          
          
          <tr>
            <td valign="top" align="right"><strong class="font11">Additional Details</strong></td>
            <td valign="top">:</td>
            <td valign="middle" align="left"><textarea class="input input2 textarea" rows="3" cols="40" id="details" name="add_details"></textarea></td>
          </tr>
          
          
               <tr>
                    <td  align="right"> </td>
                    <td></td>
                    <td align="left"><input value="Submit" class="submit-button " name="submit" type="submit"> &nbsp;  &nbsp;  &nbsp;<input type="button" onclick="formReset()" value="Reset" class="submit-button "></td>
                      </tr>
                      
                    </table>
                 </form>
</body>
</html>