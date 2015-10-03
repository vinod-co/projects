<?php
	// check the username/email_address for validity and 
	// send an email
	
	include_once "config.php";
	include_once "functions.php";

	// $username_email = null;
	// $_POST["username_email"] = 'aadkum890@freemail.com';

	if(isset($_POST["username_email"])){
		$username_email = $_POST["username_email"];
		$sql = "select count(*) from users where ? in (username, email)";
		$count = R::getCell($sql, array($username_email))[0];

		if($count==0){
			// echo "Invalid username or email.";
			store_in_session("message", "Invalid username or email.");
			header("Location: forgot_password.php");
			return;
		}
	}
	else {
		// echo "Please enter username/password.";
		store_in_session("message", "Please enter username/email.");
		header("Location: forgot_password.php");
		return;
	}
	
	// echo "All is well!";
	$pass = generate_password();
	$sql = "update users set password = ? where ? in (username, email)";
	R::exec($sql, array(md5($pass), $username_email));

	// send an email to the user containing the new password

	$sql = "select * from users where ? in (username, email)";
	$row = R::getRow($sql, array($username_email));
	$fname = $row["firstname"];
	$email =  $row["email"];
	$data = array();
	$data["reply_to_email"] = "admin@madhwaconnect.com";
	$data["reply_to_name"] = "Administrator - MadhwaConnect";
	$data["from_email"] = "admin@madhwaconnect.com";
	$data["from_name"] = "Administrator - MadhwaConnect";
	$data["email_id"] = $email;
	$data["subject"] = "We have reset your password.";
	$data["content"] = <<<EOT
<h3>Dear {$fname},</h3>
<p>As requested by you, we have reset your password</p>
<p>Here is your new password: {$pass}</p>
<p>You can now <a href="http://madhwaconnect.com/services/login_f.php" title="Login">login</a> to your account and we highly recommend that you immidiately change the password to your convenience</p>
<p>Always ready to help</p>
<p>Team MadhwaConnect</p>

EOT;

	if(send_email($data)){
		store_in_session("message", "Password sent to your registed email address.");
		store_in_session("email_for_password_reset", $email);

		header("Location: password_reset_link_success.php");

	}
	else{
		store_in_session("message", "There was an error. Please contact administrator.");
		header("Location: index.php");
	}
?>
