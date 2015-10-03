<?php
	// update_service.php

	include_once "config.php";
	$current_user = get_from_session("current_user");

	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	// TODO
	// check for admin role


	$id = null;
	$service = null;

	if(isset($_REQUEST["id"])){
		$id = $_REQUEST["id"];
	}
	if(isset($_REQUEST["service"])){
		$service = $_REQUEST["service"];
	}

	$out = array();

	if($id == null || $service == null){
		$out["status"] = false;
		$out["message"] = "Id or service missing";
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}

	$ser = R::load("services", $id);
	$ser->service = $service;
	R::store($ser);

	
	$out["status"] = true;

	echo json_encode($out, JSON_NUMERIC_CHECK);