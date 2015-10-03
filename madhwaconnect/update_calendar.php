<?php 

	// update_calendar.php

	$date = null;
	$action = null;
	if(isset($_REQUEST["date"])){
		$date = $_REQUEST["date"];
	}
	if(isset($_REQUEST["action"])){
		$action = $_REQUEST["action"];
	}

	include_once "config.php";

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$out = array();

	$current_user = get_from_session("current_user");
	if(is_null($current_user)){
		$out["message"] = "You must login to access this page";
		$out["status"] = false;
		echo json_encode($out);
		return;
	}

	if($action=="block"){
		$cal = R::dispense("calendar");
		$cal->user_id = $current_user["id"];
		$cal->blocked_date = $date;
		$cal->blocked_on = date("Y-m-d h:i:s");
		R::store($cal);
	}
	else if($action=="unblock") {
		$sql = "select * from calendar where user_id=? and blocked_date=?";
		$cal = R::getRow($sql, array($current_user["id"], $date));
		if(count($cal)>0){
			$sql = "delete from calendar where id=?";
			R::exec($sql, array($cal["id"]));
		}
	}

	$out["message"] = "Calendar updated successfully";
	$out["status"] = true;

	echo json_encode($out);