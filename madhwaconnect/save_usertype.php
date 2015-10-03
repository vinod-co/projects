<?php
	// save_usertype.php

	include_once "config.php";

	$current_user = get_from_session("current_user");

	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	if($current_user["username"]!="administrator"){
		store_in_session("message", "You must be an administrator to access this page");
		header("Location: index.php");
		return;
	}

	$id = null;
	$typename = null;
	$description = null;
	$fields = null;
	$approval_required = null;
	$listed_for_owntype = null;
	$not_listed_in_search = null;
	$relegious_yesno = null;

	if(isset($_REQUEST["id"])){
		$id = $_REQUEST["id"];
	}
	
	if(isset($_REQUEST["typename"])){
		$typename = $_REQUEST["typename"];
	}
	
	if(isset($_REQUEST["description"])){
		$description = $_REQUEST["description"];
	}

	if(isset($_REQUEST["fields"])){
		$fields = $_REQUEST["fields"];
	}

	if(isset($_REQUEST["approval_required"])){
		$approval_required = $_REQUEST["approval_required"];
	}

	if(isset($_REQUEST["not_listed_in_search"])){
		$not_listed_in_search = $_REQUEST["not_listed_in_search"];
	}

	if(isset($_REQUEST["relegious_yesno"])){
		$relegious_yesno = $_REQUEST["relegious_yesno"];
	}

	$out = array();

	if($typename == null || $typename == ""){
		$out["status"] = false;
		$out["message"] = "Id or typename missing";

		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}

	$usertype = null;
	$action = null;

	if($id != null && id != ""){
		$usertype = R::load("usertypes", $id);
		$action = "edit";
	}
	else {
		$usertype = R::dispense("usertypes");
		$action = "add";

	}

	$usertype->typename = $typename;
	$usertype->description = $description;
	if($fields!=null){
		$usertype->fields = implode(",", $fields);
	}
	
	$usertype->approval_required = $approval_required;
	$usertype->not_listed_in_search = $not_listed_in_search;
	$usertype->relegious_yesno = $relegious_yesno;
	
	R::store($usertype);


	$out["status"] = true;
	$out["action"] = $action;
	$out["id"] = $usertype->id;

	echo json_encode($out, JSON_NUMERIC_CHECK);
