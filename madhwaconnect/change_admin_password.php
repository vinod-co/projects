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

<div id="change_admin_password_container">

	<div id="change_admin_password_header">
		<h1>Change admin password</h1>
	</div>


<form class="classic" method="POST" 
	action="change_admin_password_action.php" >
	<fieldset>
		<legend>Change admin password</legend>

		<div>
			<p>
				<label>Enter current password</label>
				<input type="password" id="current_password" name="current_password" 
					value="" />
				<span class="error" id="error_current_password"></span>
			</p>

			<p>
				<label>Enter new password</label>
				<input type="password" id="new_password" name="new_password" 
					value="" />
				<span class="error" id="error_new_password"></span>
			</p>

			<p>
				<label>Confirm password</label>
				<input type="password" id="new_password2" name="new_password2" 
					value="" />
				<span class="error" id="error_new_password2"></span>
			</p>

			<p>
				<button class="submit">Update</button>

				<a href="" title="Don't update">Cancel</a>
			</p>

		</div>
	</fieldset>
</form>

</div>

<?php include_once "footer.php"; ?>


