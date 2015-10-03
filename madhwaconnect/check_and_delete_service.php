<?php
	// check_and_delete_service.php
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

	if(isset($_REQUEST["id"])){
		$id = $_REQUEST["id"];
	}

	$out = array();

	if($id == null){
		$out["status"] = false;
		$out["message"] = "Id missing";
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}

	$sql = "select count(*) from users where id in " 
		. "(select userid from userservices where serviceid = ?)";

	$count = R::getCell($sql, array($id));

	if($count>0){
		$out["status"] = false;
		$out["message"] = "Cant delete this service, while there are users who are offering the same";
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}

	$sql = "delete from services where id= ?";
	R::exec($sql, array($id));

	$out["status"] = true;
	echo json_encode($out, JSON_NUMERIC_CHECK);