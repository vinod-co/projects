<?php
	// create_new_service_request_action.php

	include_once "config.php";
	include_once "functions.php";

	$current_user = get_from_session("current_user");
	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	$title = null;
	$service_description = null;
	$target_usertype = null;
	
	$error_message = "";

	if(isset($_POST["title"])){
		$title = $_POST["title"];
	}
	if($title==null || $title==""){
		$error_message = "<li>Title is missing</li>";
	}

	if(isset($_POST["service_description"])){
		$service_description = $_POST["service_description"];
	}
	if($service_description==null || $service_description==""){
		$error_message .= "<li>Service description is missing</li>";
	}

	if(isset($_POST["target_usertype"])){
		$target_usertype = $_POST["target_usertype"];
	}
	if($target_usertype==null || $target_usertype==""){
		$error_message .= "<li>Target users is missing</li>";
	}

	if($error_message!=""){
		$error_message = "<h3>Errors: </h3><ul>" . $error_message . "</ul>";
		store_in_session("message", $error_message);
		header("Location: ./create_new_service_request.php");
		return;
	}

	$sr = R::dispense("servicerequests");
	$sr->title = $title;
	$sr->service_description = $service_description;
	
	$sr->status = "open";
	$sr->created_by = $current_user["id"];
	$sr->created_datetime = date("Y-m-d h:i:s");
	$sr->target_usertype = $target_usertype;

	R::store($sr);

	//store_in_session("message", "New service request has been posted successfuly, "
	//	. "and will be available for the next 15 days.");
	header("Location: ./my_service_requests.php");