<?php include_once "header.php" ?>

		<div id="forgot_password_container">
			<div class="fogot_password_header">
				<h1>Did you forget your password?</h1>
			</div>
			<div>
				<p>No problem! Please enter your username or registered email address and click the submit button. In few moments we will send a password-reset link to your registered email address.
				</p>
				<p>In case if you did not receive a mail from us, please do check in your spam/junkmail folder</p>
			</div>
			<form class="uiv2-form" action="send_password_reset_link.php" 
				method="post" onsubmit="return fnValidate_forgot_password_form(this)">
				<fieldset>
				    <div class="legend">Please provide your username or registered email address</div>
				    <div class="uiv2-form-row">
				    	<div class="gap" ></div>
				    </div>
				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label">Username / Email</span>
				        <div class="uiv2-form-input">
				        	<span>
				        		<input id="username_email" type="text" name="username_email" size="30">
				        	</span>
				        	<span class="uiv2-field-required">*</span>
				        	<span class="error" id="username_email_error"></span>
				        </div>
				    </div>

				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label"></span>
				        <div class="uiv2-form-input">
				        	<input type="submit" class="submit" value="Send link" />
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