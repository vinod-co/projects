<?php
	// change_password_action.php
	include_once "config.php";
	include_once "functions.php";

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$current_user = get_from_session("current_user");
	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	$current_password = $_POST["current_password"];
	$new_password = $_POST["new_password"];
	$new_password2 = $_POST["new_password2"];

	if(is_admin_password($current_password)){

		if($new_password!=$new_password2){
			store_in_session("message", "New passwords dont match");
		}
		else{
			store_admin_password($new_password);
			store_in_session("message", "New password successfully updated!");
		}
	}
	else{
		store_in_session("message", "Current password incorrect");
	}


	header("Location: change_admin_password.php");