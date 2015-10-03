<?php
	// change_registration_status.php

	// check for login
	// check for admin privilage

	$userid = null;
	if(isset($_REQUEST["userid"])){
		$userid = $_REQUEST["userid"];
	}

	$status = null;
	if(isset($_REQUEST["status"])){
		$status = $_REQUEST["status"];
	}

	include_once "config.php";
	$out = [];

	$curr_user = get_from_session("current_user");
	if(is_null($curr_user)){
		
		$out["status"] = true;
		$out["message"] = "you must login to access this page.";
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;		
	}

	if($status=="delete"){
		$sql = "delete from userservices where userid = ?";
		R::exec($sql, array($userid));
		$sql = "delete from users where id = ?";
		R::exec($sql, array($userid));
	}
	else{
		$sql = "update users set registration_status = ? where id=?";
		R::exec($sql, array($status, $userid));
	
		$sql = "select firstname, email from users where id = ?";
		$the_user = R::getRow($sql, array($userid));

		// send mail
		$data = array();
		$data["reply_to_email"] = "noreply@madhwaconnect.com";
		$data["reply_to_name"] = "Pls. do not reply to this";
		$data["from_email"] = "admin@madhwaconnect.com";
		$data["from_name"] = "Administrator, MadhwaConnect";
		$data["email_id"] = $the_user["email"];
		



		if($status=="approved"){
			$data["subject"] = "Approved - Welcome to Mahdwa Connect";
			$data["content"] = <<<EOT
<div>
<p>Dear {$the_user["firstname"]},</p>
<p>Congratulations! Welcome to Madhwa connect family. We are glad to inform you that your registration in to Madhwa connect has been accepted.  We value your association with us on our journey towards Madhwa Connect. We look forward to your greater participation and association in facilitating Madhwa community.</p>
<p>Wish you all best for future endeavours.</p>
<p>Regards,</p>
<p>Madhwa Connect</p>
</div>
EOT;
		}
		else if($status=="suspended"){
			$data["subject"] = "Your account has been temporarily suspended";
			$data["content"] = <<<EOT
<div>
<p>Dear {$the_user["firstname"]},</p>
<p>We are extremely sorry to inform that your account with Madhwa connect has been suspended temporarily. The reason for this will not be disclosed. We will personally review your account once more and contact you as soon as possible</p>
<p>Wish you all best for future endeavours.</p>
<p>Regards,</p>
<p>Madhwa Connect</p>
</div>
EOT;
		}
		else {
			$data["subject"] = "Request Declined";
			$data["content"] = <<<EOT
<div>
<p>Dear {$the_user["firstname"]},</p>
<p>Good day. This is with respect to your registration into Madhwaconnect;we appreciate your interest in our organization. As per our terms and conditions, we regret to inform you that we are not able consider your request.</p>
<p>Thank you for showing interest in our organization, however we keep your details for future reference. </p>
<p>Regards,</p>
<p>Madhwa Connect</p>
</div>
EOT;
		}

		send_email($data);
	}
	
	

	$out["status"] = true;

	echo json_encode($out, JSON_NUMERIC_CHECK);