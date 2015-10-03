<?php

include_once "config.php";

try {
$is_valid = true;

// set $is_valid = false, if any of the following fails

if(isset($_FILES["profile_picture"])){
	$path = "images/" . round(microtime(true));
	mkdir($path);
	$attachment = $path . "/" . $_FILES["profile_picture"]["name"];
	move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $attachment);	
}

// get all inputs
$firstname = trim($_POST["firstname"]);
$lastname = trim($_POST["lastname"]);
$cellphone = trim($_POST["cellphone"]);
$email = trim($_POST["email"]);
$username = trim($_POST["username"]);
$password = trim($_POST["password"]);
$confirm_password = trim($_POST["confirm_password"]);
$type = trim($_POST["usertype"]);
$human_check = trim($_POST["human_check"]);


// check for empty inputs
if(strlen($firstname)==0){
	
}
// check for numerics in phone
// check for email pattern
// check for existence of phone
// check for existence of email
// check for existence of username

if($is_valid){
	unset($_POST["confirm_password"]);
	unset($_POST["human_check"]);

	$services = $_POST["service"];
	unset($_POST["service"]);

	$new_user = R::dispense("users");
	$new_user->import($_POST);
	$new_user->date_of_registration = date('Y-m-d h:i:s');
	$new_user->password = md5($new_user->password);
	$new_user->profile_picture = $attachment;
	
	$approval_required = R::getCell(
		"select approval_required from usertypes where id =?",
		array($new_user->usertype));
	
	if($approval_required==1){
		$new_user->registration_status = "pending";
	}
	else{
		$new_user->registration_status = "approved";
	}

	store_in_session("approval_required", $approval_required);
	// print_r($new_user);

	R::store($new_user);

	// echo "-------------------------\n";

	if(!empty($services)){
		foreach($services as $service){
			$userservice = R::dispense("userservices");
			$userservice->userid = $new_user->id;
			$userservice->serviceid = $service;
			// echo "===========================\n";
			// print_r($userservice);
			R::store($userservice);
		}		
	}




	// send email

	$data = array();
	$data["reply_to_email"] = "admin@madhwaconnect.com";
	$data["reply_to_name"] = "Administrator, MadhwaConnect";
	$data["from_email"] = "admin@madhwaconnect.com";
	$data["from_name"] = "Administrator, MadhwaConnect";
	$data["email_id"] = $new_user->email;
	$data["subject"] = "Welcome to MadhwaConnect";
	$data["content"] = <<<EOT
<div>
<p>Dear {$new_user->firstname},</p>
<p>Welcome to Madhwa connect and congratulations for registering in Madhwa connect successfully. We are glad to have you as our member. We hope you will explore the services provided by Madhwa connect platform and utilize this to the fullest extent. </p>
<p>For any queries and feedback, you can mail us at admin@madhwaconnect.com</p>
<p>Regards,</p>
<p>Madhwa Connect</p>
</div>
EOT;

	if($approval_required==1){
		$data["content"] = <<<EOT
<div>
<p>Dear {$new_user->firstname},</p>
<p>Thanks for registering in Madhwa Connect. Madhwa admin will review the complete details and will revert back to you at the earliest by sending you a confirmation mail to your registered e-mail id.</p>
<p>Regards,</p>
<p>Madhwa Connect</p>
</div>
EOT;
	}
	send_email($data);

	header("Location: next_step.php");	
}
else{

}

}
catch(Exception $e){
	store_in_session("message", "There was an error!<br />" . $e->getMessage());
	header("Location: ./");
}