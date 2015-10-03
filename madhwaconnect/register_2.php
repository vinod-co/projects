<?php include_once "header.php" ?>
	<div id="register_container">
		<div class="register_header">
			<h1>Register</h1>
		</div>
		<div>
			<p>Thank you for the interest in registration and membership at MadhwaConnect.com. If you have any queries or concerns about our services, please send an email with details to admin@madhwaconnect.com. We will get in touch with you as early as possible and address the matter.
			</p>
			<p>Fields marked with * are mandatory</p>
		</div>


		<form class="uiv2-form">

			<fieldset>
			    <div class="legend">Login details</div>

			    <div class="uiv2-form-row">
			    	<span class="uiv2-form-label">Username</span>
			        <div class="uiv2-form-input">
			        	<span>
			        		<input id="username" type="text" name="username" size="30">
			        	</span>
			        	<span class="uiv2-field-required">*</span>
			        </div>
			    </div>
			    <div class="uiv2-form-row">
			    	<span class="uiv2-form-label">Password</span>
			        <div class="uiv2-form-input">
			        	<span>
			        		<input id="password" type="password" name="password" size="30">
			        	</span>
			        	<span class="uiv2-field-required">*</span>
			        </div>
			    </div>
			    <div class="uiv2-form-row">
			    	<span class="uiv2-form-label">Confirm password</span>
			        <div class="uiv2-form-input">
			        	<span>
			        		<input id="c_password" type="password" name="c_password" size="30">
			        	</span>
			        	<span class="uiv2-field-required">*</span>
			        </div>
			    </div>
			</fieldset>

			<fieldset>
			    <div class="legend">Personal Details</div>

			    <div class="uiv2-form-row">
			    	<span class="uiv2-form-label">First Name</span>
			        <div class="uiv2-form-input">
			        	<span>
			        		<input id="first_name" type="text" name="first_name" size="30">
			        	</span>
			        	<span class="uiv2-field-required">*</span>
			        </div>
			    </div>
			    <div class="uiv2-form-row">
			    	<span class="uiv2-form-label">Last Name</span>
			        <div class="uiv2-form-input">
			        	<span>
			        		<input id="last_name" type="text" name="last_name" size="30">
			        	</span>
			        	<span class="uiv2-field-required">*</span>
			        </div>
			    </div>
			    <div class="uiv2-form-row">
			    	<span class="uiv2-form-label">Mobile number</span>
			        <div class="uiv2-form-input">
			        	<span>
			        		<input type="text" id="cellphone" name="cellphone" size="15"  />
			        	</span>
			        	<span class="uiv2-field-required">*</span>
			        </div>
			    </div>
			    <div class="uiv2-form-row">
			    	<span class="uiv2-form-label">Email address</span>
			        <div class="uiv2-form-input">
			        	<span>
			        		<input id="email_address" type="text" name="email_address" size="15">
			        	</span>
			        	<span class="uiv2-field-required">*</span>
			        </div>
			    </div>
			</fieldset>

			
		</form>
	</div>
<?php include_once "footer.php" ?>