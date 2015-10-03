<?php
	// check_and_delete_category.php

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

	$sql = "delete from userservices where serviceid in (select id from services where category_id = ?)";
	R::exec($sql, array($id));
	$sql = "delete from services where category_id = ?";
	R::exec($sql, array($id));
	$sql = "delete from categories where id = ?";
	R::exec($sql, array($id));

	$out["status"] = true;
	echo json_encode($out, JSON_NUMERIC_CHECK);