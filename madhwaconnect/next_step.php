<?php include_once "header.php";?>
<div id="next_steps_container">
	<div class="next_steps_header">
		<p>
			<a href="./">Home</a>
		</p>
		<h1>Next steps</h1>
	</div>

	<?php
		$approval_required = get_from_session("approval_required");
		if($approval_required==0){

	?>

	<!-- For users who do not need admin approval -->
	<div>
		<p>Thank for registering and your registration details have been accepted. Now you can login and explore Madhwa connect services.</p>

		<p>As part of our anti-spam policy, we have sent an mail to your registered email address. You will receive the same in a while. Please check your "Junk Mail" folder also.</p>

		<p>Please click the link in the email to update the additional information.</p>
		<p>You may close this window now. </p>
	</div>

	<?php
		}
		else {
	?>

	<!-- For users who NEED admin approval -->
	<div>
		<p>Thanks for registering in Madhwa Connect. We are in process of Madhwa admin will review the complete details and will revert back to you at the earliest by sending you confirmation mail to your registered e-mail id.</p>

		<p>As part of our anti-spam policy, we have sent a mail to your registered email address. You will receive the same in a while. Please check your "Junk Mail" folder also. </p>

		<p>You may close this window now. </p>
	</div>

	<?php
		}
	?>
</div>
<?php include_once "footer.php";?>