<?php
	include_once "config.php"; 
	include_once "functions.php";

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if (!isset($_SESSION["current_user"])) {
		$_SESSION["message"] = "You need to login for accessing this page";
		header("Location: ./index.php");
		return;
	}
?>
<?php include_once "header.php"; ?>
<?php include_once "menu.php"; ?>

<div id="edit_profile_container">
	<div id="edit_profile_header">
		<h1>Edit your profile</h1>
	</div>


<form class="classic" method="POST" 
	action="edit_profile_action.php" >
	<fieldset>
		<legend>Review / update your profile</legend>

		<div>

			<p>
				<label>Usertype</label>
				<label><?php echo get_usertype($current_user["usertype"]); ?></label>
			</p>

			<p>
				<label>Firstname</label>
				<input type="text" id="firstname" name="firstname" 
					value="<?php echo $current_user["firstname"];?>" />
				<span class="error" id="error_firstname"></span>
			</p>

			<p>
				<label>Lastname</label>
				<input type="text" id="lastname" name="lastname" 
					value="<?php echo $current_user["lastname"];?>" />
				<span class="error" id="error_lastname"></span>
			</p>

			<p>
				<label>Cellphone</label>
				<input type="text" id="cellphone" name="cellphone" 
					value="<?php echo $current_user["cellphone"];?>" />
				<span class="error" id="error_cellphone"></span>
			</p>
			<p>
				<label>Email address</label>
				<input type="text" id="email" name="email" 
					value="<?php echo $current_user["email"];?>"  
					style="width: 400px" />
				<span class="error" id="error_email"></span>
			</p>
			<p>		
				<label>Address</label>	
				<input type="text" id="addr1" name="addr1" 	
					value="<?php echo $current_user["addr1"];?>"  
					style="width: 400px" />
				<span class="error" id="error_addr1"></span>	
			</p>		
			<p>		
				<label>Area</label>	
				<input type="text" id="addr2" name="addr2" 	
					value="<?php echo $current_user["addr2"];?>"  
					style="width: 400px" />
				<span class="error" id="error_addr2"></span>	
			</p>		
			<p>		
				<label>City</label>	
				<input type="text" id="city" name="city" 	
					value="<?php echo $current_user["city"];?>" />
				<span class="error" id="error_city"></span>	
			</p>		
			<p>		
				<label>State</label>	
				<input type="text" id="state" name="state" 	
					value="<?php echo $current_user["state"];?>" />
				<span class="error" id="error_state"></span>	
			</p>		
			<p>		
				<label>Pincode</label>	
				<input type="text" id="pincode" name="pincode" 	
					value="<?php echo $current_user["pincode"];?>" />
				<span class="error" id="error_pincode"></span>	
			</p>		
			<p>		
				<label>Country</label>	
				<input type="text" id="country" name="country" 	
					value="<?php echo $current_user["country"];?>" />
				<span class="error" id="error_country"></span>	
			</p>



			<div id="divAdditionalFieldsForThisUsertype">
			</div>

			<p>
				<button class="submit">Update</button>

				<a href="" title="Abandon changes">Cancel</a>
			</p>
		</div>


	</fieldset>
</form>


<div id="divAdditionalFields" style="display: none; ">
	<p>
		<label>Alternate cellphone</label>
		<input type="text" id="another_cellphone" name="another_cellphone" 
			value="<?php echo $current_user["another_cellphone"];?>" />
		<span class="error" id="error_another_cellphone"></span>
	</p>
	<p>
		<label>Landline number</label>
		<input type="text" id="landline" name="landline" 
			value="<?php echo $current_user["landline"];?>" />
		<span class="error" id="error_landline"></span>
	</p>
	<p>
		<label>Alternate Landline number</label>
		<input type="text" id="another_landline" name="another_landline" 
			value="<?php echo $current_user["another_landline"];?>" />
		<span class="error" id="error_another_landline"></span>
	</p>
	<p>		
		<label>Alternate email address</label>	
		<input type="text" id="another_email" name="another_email" 	
			value="<?php echo $current_user["another_email"];?>"  
			style="width: 400px" />
		<span class="error" id="error_another_email"></span>	
	</p>		
		
	<p>		
		<label>Company name</label>	
		<input type="text" id="company_name" name="company_name" 	
			value="<?php echo $current_user["company_name"];?>" />
		<span class="error" id="error_company_name"></span>	
	</p>		
	<p>		
		<label>Experience (Years)</label>	
		<input type="text" id="exp_years" name="exp_years" 	
			value="<?php echo $current_user["exp_years"];?>"  
			style="width: 50px" />
		<span class="error" id="error_exp_years"></span>	
	</p>		
	<p>		
		<label>Experience (Months)</label>	
		<input type="text" id="exp_months" name="exp_months" 	
			value="<?php echo $current_user["exp_months"];?>"  
			style="width: 50px" />
		<span class="error" id="error_exp_months"></span>	
	</p>		
	<p>		
		<label>Profession</label>	
		<input type="text" id="profession" name="profession" 	
			value="<?php echo $current_user["profession"];?>"  
			style="width: 400px" />
		<span class="error" id="error_profession"></span>	
	</p>		
	<p>		
		<label>Gotra</label>	
		<input type="text" id="gotra" name="gotra" 	
			value="<?php echo $current_user["gotra"];?>" />
		<span class="error" id="error_gotra"></span>	
	</p>		
	<p>		
		<label>Matha</label>	
		<input type="text" id="matha" name="matha" 	
			value="<?php echo $current_user["matha"];?>"  
			style="width: 400px" />
		<span class="error" id="error_matha"></span>	
	</p>		
	<p>		
		<label>Qualification</label>	
		<input type="text" id="qualification" name="qualification" 	
			value="<?php echo $current_user["qualification"];?>" 
			style="width: 400px" />
		<span class="error" id="error_qualification"></span>	
	</p>		
	<p>
		<label>Brief description</label>	
		<input type="text" id="additional_info" name="additional_info" 	
			value="<?php echo $current_user["additional_info"];?>" 
			style="width: 700px" />
		<span class="error" id="error_additional_info"></span>	
	</p>	
</div>

<?php
	$usertype_fields = R::getCell("select fields from usertypes where id = ?", 
		array($current_user["usertype"]));
?>
<script type="text/javascript">
	var fieldsToShow = "<?php echo $usertype_fields; ?>";

	if(fieldsToShow){
		fieldsToShow = fieldsToShow.split(",");
		
		$.each(fieldsToShow, function(i, v){
			field = $("#divAdditionalFields").find("#"+v).closest("p").html();
			$("<p>").append(field).appendTo("#divAdditionalFieldsForThisUsertype");
		});				
	}
</script>

</div>
<?php include_once "footer.php"; ?>
