<?php

	// post_email.php
	
	$subject = null;
	$message_text = null;
	$to_id = null;

	if(isset($_REQUEST["subject"])){
		$subject = $_REQUEST["subject"];
	}

	if(isset($_REQUEST["message_text"])){
		$message_text = $_REQUEST["message_text"];
	}

	if(isset($_REQUEST["to_id"])){
		$to_id = $_REQUEST["to_id"];
	}

	$out = array();
	if(is_null($subject)){
		$out["status"] = false;
		$out["message"] = "Subject is missing.";
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}
	if(is_null($message_text)){
		$out["status"] = false;
		$out["message"] = "Message text is missing.";
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}

	include_once "config.php";

	$current_user = get_from_session("current_user");
	$to_email_id = R::getCell("select email from users where id = ?", array($to_id));

	$data = array();
	$data["reply_to_email"] = $current_user["email"];
	$data["reply_to_name"] = $current_user["firstname"] . " " . $current_user["lastname"];
	$data["from_email"] = "admin@madhwaconnect.com";
	$data["from_name"] = "Administrator - MadhwaConnect";
	$data["email_id"] = $to_email_id;
	$data["subject"] = $subject;
	$data["content"] = $message_text;

	if(send_email($data)){
		$out["status"] = true;
		$out["message"] = "Email sent successfully!";
	}
	else{
		$out["status"] = false;
		$out["message"] = "Email sending failed!";
	}
	
	echo json_encode($out, JSON_NUMERIC_CHECK);