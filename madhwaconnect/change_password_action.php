<?php
	// change_password_action.php
	include_once "config.php"; 

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

	$data = R::getRow("select * from users where username=? and password=md5(?)", 
		array($current_user["username"], $current_password));

	if(count($data)==0){
		store_in_session("message", "Current password incorrect");
	}
	else if($new_password!=$new_password2){
		store_in_session("message", "New passwords dont match");
	}
	else {
		$sql = "update users set password = md5(?) where username=?";
		R::exec($sql, array($new_password, $current_user["username"]));
		store_in_session("message", "New password successfully updated!");	
	}

	header("Location: change_password.php");