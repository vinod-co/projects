<?php

// edit_profile_action.php

	include_once "config.php";
	$current_user = get_from_session("current_user");

	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	$me = R::load("users", $current_user["id"]);
	$me->import($_POST);
	R::store($me);

	$sql = "select * from users where id = ?";
	$data = R::getRow($sql, array($current_user["id"]));
	$_SESSION["current_user"] = $data;
	
	$_SESSION["message"] = "Profile successfully updated!";

	header("Location: edit_profile.php");