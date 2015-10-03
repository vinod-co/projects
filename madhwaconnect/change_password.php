<?php
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

<?php
	// dashboard.php

	include_once "config.php"; 



?>

<?php include_once "menu.php"; ?>
<div id="change_password_container">
	<div id="change_password_header">
		<h1>Change password</h1>
	</div>


<form class="uiv2-form" method="POST" 
	action="change_password_action.php" >
	<fieldset>
		<div class="legend">Please enter details</div>

		<div class="uiv2-form-row">
			<span class="uiv2-form-label">Enter current password</span>
			<div class="uiv2-form-input">
	        	<span>
	        		<input type="password" id="current_password" name="current_password" 
					value="" />
	        	</span>
	        	<span class="uiv2-field-required">*</span>
	        	<span class="error" id="error_current_password"></span>
	        </div>
	    </div>

	    <div class="uiv2-form-row">
			<span class="uiv2-form-label">Enter new password</span>
			<div class="uiv2-form-input">
	        	<span>
	        		<input type="password" id="new_password" name="new_password" 
					value="" />
	        	</span>
	        	<span class="uiv2-field-required">*</span>
	        	<span class="error" id="error_new_password"></span>
	        </div>
	    </div>


	    <div class="uiv2-form-row">
			<span class="uiv2-form-label">Confirm password</span>
			<div class="uiv2-form-input">
	        	<span>
	        		<input type="password" id="new_password2" name="new_password2" 
					value="" />
	        	</span>
	        	<span class="uiv2-field-required">*</span>
	        	<span class="error" id="error_new_password2"></span>
	        </div>
	    </div>

	    <div class="uiv2-form-row">
			<span class="uiv2-form-label">&nbsp;</span>
			<div class="uiv2-form-input">
	        	<button class="submit">Update</button>
				<a href="" title="Don't update">Cancel</a>
	        </div>
	    </div>

	</fieldset>
</form>



</div>
<?php include_once "footer.php"; ?>

