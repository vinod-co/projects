<?php
	// update_profile_picture_action.php
	include_once "config.php";

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION["current_user"])){
		$current_user = $_SESSION["current_user"];
		$current_user_fullname = $current_user["firstname"] . " " . $current_user["lastname"];
		$user_loggedin = true;
	}
	else{
		$user_loggedin = false;
	}

	// if user not logged in redirect to index.php

	if(!$user_loggedin){
		$_SESSION["message"] = "You must login to access this page";
		header("Location: index.php");
		return;
	}

	if($_FILES["profile_picture"]["name"]==null){
		store_in_session("message", "You have not selected any picture!");
		header("Location: update_profile_picture.php");
		return;
	}

	
	$current_profile_picture = $current_user["profile_picture"];
	$current_profile_picture_folder = substr($current_profile_picture, 0, 
		strrpos($current_profile_picture, "/", -1));

	$path = "images/" . round(microtime(true));
	mkdir($path);
	$attachment = $path . "/" . $_FILES["profile_picture"]["name"];
	move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $attachment);

	$cu = R::load("users", $current_user["id"]);
	$cu->profile_picture =  $attachment;
	R::store($cu);
	
	// delete the old profile picture and the folder
	if(file_exists($current_profile_picture)){
		unlink($current_profile_picture);
	}
	if(file_exists($current_profile_picture_folder)){
		rmdir($current_profile_picture_folder);
	}
	
	
	$current_user["profile_picture"] = $cu->profile_picture;

	$_SESSION["current_user"] = $current_user;

	$_SESSION["message"] = "Profile picture successfully updated!";

	header("Location: update_profile_picture.php");