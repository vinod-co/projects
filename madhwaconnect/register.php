<?php include_once "header.php"; ?>

<?php
	$num1 = rand(0, 9);
	$num2 = rand(0, 9);

	if($num2>$num1){
		$temp = $num1;
		$num1 = $num2;
		$num2 = $temp;
	}

	$op = substr("+-", rand(0,1), 1);

	$human_check_expr = "{$num1} {$op} {$num2}";
	$result = eval("return ({$num1} {$op} ${num2});");
?>

<script type="text/javascript">
	window.human_check_result = <?php echo $result; ?>;
</script>
<style type="text/css">
	.serviceitem {
		width: 250px;
		display: inline-block;
	}

</style>

<script type="text/javascript" src="script/new_user_validation.js"></script>

<div id="register_container">
	<div class="register_header">
		<p>
			<a href="./">Home</a>
		</p>
		<h1>Register</h1>
	</div>
	<div>
		<p>Thank you for the interest in registration and membership at MadhwaConnect.com. If you have any queries or concerns about our services, please send an email with details to admin@madhwaconnect.com. We will get in touch with you as early as possible and address the matter.
		</p>
		<p>Fields marked with * are mandatory</p>
	</div>

	<form class="uiv2-form" method="POST" 
		action="register_action.php"
		enctype="multipart/form-data" 
		onsubmit="return fnValidateNewUserRegistration(this) && fnValidateForm();">
		<fieldset>
			<div class="legend">Login details</div>

		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Desired username</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<input id="username" type="text" name="username" size="30">
		        	</span>
		        	<span class="uiv2-field-required">*</span>
					<a href="javascript:void()" onclick="fnCheckUsernameAvailability()">Available?</a>
					<span id="availability"></span>
					<span class="error" id="error_username"></span>
		        </div>
		    </div>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Password</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<input id="password" type="password" name="password" size="30">
		        	</span>
		        	<span class="uiv2-field-required">*</span>
		        	<span class="error" id="error_password"></span>
		        </div>
		    </div>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Confirm password</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<input type="password" id="confirm_password" name="confirm_password"  size="30">
		        	</span>
		        	<span class="uiv2-field-required">*</span>
		        	<span class="error" id="error_confirm_password"></span>
		        </div>
		    </div>
		</fieldset>

		<fieldset>
		    <div class="legend">Personal Details</div>

		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">First Name</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<input id="firstname" type="text" name="firstname" size="30">
		        	</span>
		        	<span class="uiv2-field-required">*</span>
		        	<span class="error" id="error_firstname"></span>
		        </div>
		    </div>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Last Name</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<input id="lastname" type="text" name="lastname" size="30">
		        	</span>
		        	<span class="uiv2-field-required">*</span>
		        	<span class="error" id="error_lastname"></span>
		        </div>
		    </div>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Mobile number</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<input type="text" id="cellphone" 
		        			name="cellphone" size="15" 
		        			placeholder="10 digits only" />
		        	</span>
		        	<span class="uiv2-field-required">*</span>
		        	<span class="error" id="error_cellphone"></span>
		        </div>
		    </div>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">Email address</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<input id="email" type="text" name="email" size="15">
		        	</span>
		        	<span class="uiv2-field-required">*</span>
		        	<span class="error" id="error_email"></span>
		        </div>
		    </div>
	<div class="show_hide_field" id="addr1_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Address</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="addr1" name="addr1"  style="width: 400px;" />
	        	</span><span class="error" id="error_addr1"></span>
	        </div>
	    </div>
	</div>
	
	<div class="show_hide_field" id="addr2_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Area</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="addr2" name="addr2"  style="width: 400px;" />
	        	</span>
	        	<span class="uiv2-field-required">*</span>
	        	<span class="error" id="error_addr2"></span>
	        </div>
	    </div>
	</div>
	<div class="show_hide_field" id="city_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">City</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="city" name="city" />
	        	</span>
	        	<span class="uiv2-field-required">*</span>
	        	<span class="error" id="error_city"></span>
	        </div>
	    </div>
	</div>
	
	<div class="show_hide_field" id="state_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">State</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="state" name="state" />
	        	</span><span class="error" id="error_state"></span>
	        </div>
	    </div>
	</div>

	<div class="show_hide_field" id="pincode_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Pincode</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="pincode" name="pincode" />
	        	</span><span class="error" id="error_pincode"></span>
	        </div>
	    </div>
	</div>	

	<div class="show_hide_field" id="country_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Country</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="country" name="country" />
	        	</span><span class="error" id="error_country"></span>
	        </div>
	    </div>
	</div>	
		    <div class="uiv2-form-row">
				<span class="uiv2-form-label">Select a profile picture (Max 1MB)</span>
				<div class="uiv2-form-input">
		        	<span>
		        		<input type="file" 
		        			style="margin-top: 10px;"
		        			id="profile_picture" name="profile_picture" 
							value="" />
		        	</span>
		        	<span class="error" id="error_profile_picture"></span>
		        </div>
		    </div>
		    <div class="uiv2-form-row">
		    	<script type="text/javascript">
					var usertypeFields = {};
				</script>
		    	<span class="uiv2-form-label">Type</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<select name="usertype" id="type" class="dropdown">
							<option value="-1"></option>

							<?php
								include_once "config.php";
								$usertypes = R::getAll("select * from usertypes order by typename");
								
								foreach($usertypes as $usertype){
									echo "<option value='{$usertype['id']}'>{$usertype['typename']}</option>";

									?>
									<script type="text/javascript">
										usertypeFields["<?php echo $usertype['id']; ?>"] = "<?php echo $usertype['fields']; ?>";
									</script>
									<?php
								}
							?>
						</select>
		        	</span>
		        	<span class="uiv2-field-required">*</span>
		        	<span class="error" id="error_type"></span>
		        </div>
		    </div>
			
		</fieldset>

		<div id="divServices">
		</div>

		<fieldset>
			<div class="legend">Additional fields</div>
			<div id="divAdditionalFields">
				<h3 style="margin-left: 20px;">Please select a user type from the above dropdown list.</h3>
			</div>
		</fieldset>

		<fieldset>
			<div class="legend">Just checking if you are a human...</div>
		    <div class="uiv2-form-row">
		    	<span class="uiv2-form-label">What is <?php echo $human_check_expr;?> ?</span>
		        <div class="uiv2-form-input">
		        	<span>
		        		<input type="text" id="human_check" name="human_check"
							placeholder="Not a robot :-)" />
		        	</span>
		        	<span class="uiv2-field-required">*</span>
		        	<span class="error" id="error_human_check"></span>
		        </div>
		    </div>
		</fieldset>

		<p>
			<input type="checkbox" name="tnc" id="tnc" />
			I agree to the MadhwaConnect <a target="_blank" id="tnc_link" href="tnc.php?nh">Terms and conditions</a>
			<span class="error" id="error_tnc"></span>
		</p>

		<p>
			<button class="submit">Register</button>
			<a href="/" >Cancel</a>
		</p>

		<p class="note">
			Note: Fields marked with * are mandatory
		</p>
	</fieldset>
</form>

<?php
	
	foreach($usertypes as $usertype){
		?>
	<div id="usertype<?php echo $usertype["id"]; ?>" style="display: none">
		<?php
			$sql = "select * from categories where usertype=? order by category";
			$categories = R::getAll($sql, array($usertype["id"]));

			foreach($categories as $category){
		?>
		<div id="category<?php echo $category["id"]; ?>">
			<fieldset>
				<div class="legend"><?php echo $category["category"]; ?></div>
				<div style="padding: 20px 20px 0;">
					<span class="linkSelectAll">Select all</span> 
					<span class="linkDeselectAll">Deselect all</span> 
				</div>
				<div style="padding: 20px;">
					<?php
						$sql = "select * from services where category_id=? order by service";
						$services = R::getAll($sql, array($category["id"]));

						foreach($services as $service){
							?>
							<span class="serviceitem"><input type="checkbox" id="service" name="service[]" 
								value="<?php echo $service["id"]; ?>">
							<?php echo $service["service"]; ?></span>
							<?php
						}
					?>
				</div>
			</fieldset>
		</div>
		<?php
			}
		?>
	</div>
		<?php
	}
?>
	
<div id="hidden_fields">
	<div class="show_hide_field" id="another_cellphone_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Another cellphone</span>
	        <div class="uiv2-form-input">
	        	<span><input type="text" id="another_cellphone" name="another_cellphone" />
	        	</span><span class="error" id="error_another_cellphone"></span>
	        </div>
	    </div>
	</div>

	<div class="show_hide_field" id="another_email_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Another email</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="another_email" name="another_email" style="width: 400px;" />
	        	</span><span class="error" id="error_another_email"></span>
	        </div>
	    </div>
	</div>
	
	<div class="show_hide_field" id="landline_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Landline</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="landline" name="landline" />
	        	</span><span class="error" id="error_landline"></span>
	        </div>
	    </div>
	</div>
	
	<div class="show_hide_field" id="another_landline_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Another landline</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="another_landline" name="another_landline" />
	        	</span><span class="error" id="error_another_landline"></span>
	        </div>
	    </div>
	</div>
	


	<div class="show_hide_field" id="company_name_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Company name</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="company_name" name="company_name"  style="width: 400px;" />
	        	</span><span class="error" id="error_company_name"></span>
	        </div>
	    </div>
	</div>	

	<div class="show_hide_field" id="exp_years_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Experience (Years)</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="exp_years" name="exp_years"  style="width: 50px;" />
	        	</span><span class="error" id="error_exp_years"></span>
	        </div>
	    </div>
	</div>	

	<div class="show_hide_field" id="exp_months_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Experience (Months)</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="exp_months" name="exp_months" style="width: 50px;"  />
	        	</span><span class="error" id="error_exp_months"></span>
	        </div>
	    </div>
	</div>	

	<div class="show_hide_field" id="profession_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Profession</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="profession" name="profession" />
	        	</span><span class="error" id="error_profession"></span>
	        </div>
	    </div>
	</div>	

	<div class="show_hide_field" id="gotra_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Gotra</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="gotra" name="gotra" />
	        	</span><span class="error" id="error_gotra"></span>
	        </div>
	    </div>
	</div>	

	<div class="show_hide_field" id="matha_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Mutt</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="matha" name="matha" />
	        	</span><span class="error" id="error_matha"></span>
	        </div>
	    </div>
	</div>	

	<div class="show_hide_field" id="qualification_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Qualification</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="qualification" name="qualification" />
	        	</span><span class="error" id="error_qualification"></span>
	        </div>
	    </div>
	</div>	

	<div class="show_hide_field" id="additional_info_field_container">
	    <div class="uiv2-form-row">
	    	<span class="uiv2-form-label">Additional info</span>
	        <div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="additional_info" name="additional_info" style="width: 600px;"  />
	        	</span><span class="error" id="error_additional_info"></span>
	        </div>
	    </div>
	</div>

</div>

<script type="text/javascript">
	$(function(){

		$("select#type").on("change", function(){
			debugger;
			$("#divServices").html("");

			var id = "#usertype" + $(this).val();
			$("#divServices").html($(id).html());
			$("span.linkSelectAll").click(function(){
				var checkboxes = $(this).closest("fieldset").find("input[type=checkbox]");
				checkboxes.prop("checked", true);
			});		
			$("span.linkDeselectAll").click(function(){
				var checkboxes = $(this).closest("fieldset").find("input[type=checkbox]");
				checkboxes.prop("checked", false);
			});	

			var fieldsToShow = usertypeFields[$(this).val()];
			$("#divAdditionalFields").html("");
			
			if(fieldsToShow){
				fieldsToShow = fieldsToShow.split(",");
				
				$.each(fieldsToShow, function(i, v){
					field = $("#"+v+"_field_container").html();
					console.log("#"+v+"_field_container");
					$("#divAdditionalFields").append(field);
				});				
			}
	
		});

		$("#hidden_fields").css("display", "none");
	});
</script>
<script type="text/javascript">
	$(function(){
		$('#profile_picture').bind('change', function() {
			window.do_not_upload = false;
			var size = this.files[0].size;
			var limit = 1024*1024; // 1MB
			if(size>limit){
				window.do_not_upload = true;
			}
		});
	});

	var fnValidateForm = function(){
		if(window.do_not_upload && window.do_not_upload==true){
			fnShowMessage("Please choose another file <br />(less than 1MB)");
			return false;
		}
		return true;
	};
</script>

<?php include_once "footer.php"; ?>