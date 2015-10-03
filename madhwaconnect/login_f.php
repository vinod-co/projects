<?php include_once "header.php" ?>

		<div id="register_container">
			<div class="register_header">
				<p>
					<a href="./">Home</a>
				</p>
				<h1>Please login</h1>
			</div>
			<form class="uiv2-form" action="login.php" method="post">
				<fieldset>
				    <div class="legend">You can login using username or registered email address</div>
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
				    	<span class="uiv2-form-label">&nbsp;</span>
				    	<div class="uiv2-form-input">
				    		<input type="checkbox" id="keep_me_logged_in" name="keep_me_logged_in"
				    			value="1"> Keep me logged in
				    	</div>
				    </div>
				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label"></span>
				        <div class="uiv2-form-input">
				        	<input type="submit" class="submit" value="Login" />
				        </div>
				    </div>
				    <div class="uiv2-form-row">
				    	<div class="gap" ></div>
				    </div>
				    <div class="uiv2-form-row">
				    	<span class="uiv2-form-label"></span>
				    	<div class="uiv2-form-input">
					    	<a href="forgot_password.php">Forgot password</a>
					    </div>
				    </div>
				    <div class="uiv2-form-row">
				    	<div class="gap" ></div>
				    </div>
				</fieldset>

				
			</form>
		</div>

<?php include_once "footer.php" ?>