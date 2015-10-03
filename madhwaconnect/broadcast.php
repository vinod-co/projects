<?php
	// broadcast.php

	include_once "config.php";
	include_once "header.php";
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
		<h1>Broadcast</h1>
		<p>
			As an administrator you can send a message to all service providers or specific service providers.
		</p>
	</div>


<form class="uiv2-form" method="POST" 
	action="broadcast_action.php" >
	<fieldset>
		<div class="legend">Please enter details</div>

		<div class="uiv2-form-row">
			<span class="uiv2-form-label">Message<span class="uiv2-field-required">*</span></span>
			<div class="uiv2-form-input">
	        	<span>
	        		<textarea id="message" name="message"
	        			style="width: 400px; height: 150px; margin-left: 0px; font-family: inherit; "></textarea>
	        	</span>

	        	<span class="error" id="error_message"></span>
	        </div>
	    </div>


		<div class="uiv2-form-row">
			<span class="uiv2-form-label">Targetted users</span>
			<div class="uiv2-form-input">
				<span>
				<select id="target_usertype" name="target_usertype" class="dropdown">
					<option value="-1">- - ALL - -</option>
					<?php
						foreach($usertypes as $ut){
							?>
							<option value="<?php echo $ut["id"]; ?>"><?php echo $ut["typename"]; ?></option>
							<?php
						}
					?>
				</select>
				</span>
	        	
	        	<span class="error" id="error_title"></span>
	        </div>
	    </div>

	    <div class="gap"></div>
	    <div class="uiv2-form-row">
			<span class="uiv2-form-label">&nbsp;</span>
			<div class="uiv2-form-input">
	        	<button class="submit">Send</button>
	        	&nbsp;&nbsp;
				<a href="" title="Don't update">Cancel</a>
	        </div>
	    </div>
	</fieldset>
</form>



</div>
<?php include_once "footer.php"; ?>

