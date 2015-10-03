<?php

	// create_new_service_request.php
	include_once "config.php";
	include_once "header.php";
	include_once "functions.php";
	include_once "menu.php";

	$current_user = get_from_session("current_user");

	
	if ($current_user==null) {
		store_in_session("message", "You need to login for accessing this page");
		store_in_session("redirect_to", "create_new_service_request.php");
		header("Location: ./login_f.php");
		return;
	}
?>

<?php  ?>
<div id="create_new_service_request_container">
	<div id="create_new_service_request_header">
		<h1>Create a new service request</h1>
		<p>
			If you have any specific requirement for your function or homa, and not sure of whom to contact, you may create a new request with the details of your requirement. Your request will be shown to all of our service providers and interested service providers will respond back.
		</p>
		<p>
			A service request will be kept alive for the next 15 days, and then will be automatically marked as "closed". However, if you wish to reopen the same, you may do so.
		</p>
		<p>
			We request you to close the "Service Request", once you found the right service provider, so as to avoid unnecessary communication from both the ends.
		</p>
	</div>


<form class="uiv2-form" method="POST" 
	action="create_new_service_request_action.php" >
	<fieldset>
		<div class="legend">Please enter details</div>


		<div class="uiv2-form-row">
			<span class="uiv2-form-label">Give it a title</span>
			<div class="uiv2-form-input">
	        	<span>
	        		<input type="text" id="title" name="title" 
					value="" style="width: 400px; "/>
	        	</span>
	        	<span class="error" id="error_title"></span>
	        </div>
	    </div>

		<div class="uiv2-form-row">
			<span class="uiv2-form-label">Brief description</span>
			<div class="uiv2-form-input">
	        	<span>
	        		<textarea id="service_description" name="service_description"
	        			style="width: 400px; height: 150px; margin-left: 0px; font-family: inherit; "></textarea>
	        	</span>
	        	<span class="error" id="error_service_description"></span>
	        </div>
	    </div>


		<div class="uiv2-form-row">
			<span class="uiv2-form-label">Targetted users</span>
			<div class="uiv2-form-input">
				<span>
				<select id="target_usertype" name="target_usertype" class="dropdown">
					<option value="">- - SELECT - -</option>
					<?php
						foreach($usertypes as $ut){
							?>
							<option value="<?php echo $ut["id"]; ?>"><?php echo $ut["typename"]; ?></option>
							<?php
						}
					?>
				</select>
				</span>
	        	<span class="uiv2-field-required">*</span>
	        	<span class="error" id="error_title"></span>
	        </div>
	    </div>

	    <div class="gap"></div>
	    <div class="uiv2-form-row">
			<span class="uiv2-form-label">&nbsp;</span>
			<div class="uiv2-form-input">
	        	<button class="submit">Send request</button>
	        	&nbsp;&nbsp;
				<a href="" title="Don't update">Cancel</a>
	        </div>
	    </div>
	</fieldset>
</form>



</div>
<?php include_once "footer.php"; ?>

