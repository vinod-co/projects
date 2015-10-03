<?php include_once "header.php" ?>
<?php include_once "functions.php"; ?>
		<div id="register_container">
			<div class="fogot_password_header">
				<h1>We just mailed you</h1>
			</div>
			<div>
				<p>We just sent a password-reset link to your registered email addrss. Read the mail and follow the instructions, and you can change your password.
				</p>
				<p>In case if you did not receive a mail from us, please do check in your spam/junkmail folder</p>
			</div>
			<form class="uiv2-form" action="send_password_reset_link.php" method="post">
				<input type="hidden" name="username_email" 
					value="<?php echo get_from_session("email_for_password_reset"); ?>" />

				<fieldset>
				    <div class="legend">In case if you did not receive the mail..</div>
				    <div class="uiv2-form-row">
				    	<div class="gap" ></div>
				    </div>
				    <?php
				    	// add the username/email_address here as a hidden field.
				    ?>
				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label"></span>
				        <div class="uiv2-form-input">
				        	If you want us to send the link again, please click the button below.
				        </div>
				    </div>
				    <div class="uiv2-form-row">
				    	<div class="gap" ></div>
				    </div>
				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label"></span>
				        <div class="uiv2-form-input">
				        	<input type="submit" class="submit" value="Send again" />
				        </div>
				    </div>
				    <div class="uiv2-form-row">
				    	<div class="gap" ></div>
				    </div>
				    <div class="uiv2-form-row">
				    	<div class="gap" ></div>
				    </div>
				</fieldset>

				
			</form>
		</div>

<?php include_once "footer.php" ?>