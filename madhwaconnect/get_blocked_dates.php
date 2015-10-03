<?php
	
	// get_blocked_dates.php

	$selected_month = null;
	$selected_year = null;
	$for_user = null;

	if(isset($_REQUEST["selected_month"])){
		$selected_month = $_REQUEST["selected_month"];
	}
	if(isset($_REQUEST["selected_year"])){
		$selected_year = $_REQUEST["selected_year"];
	}

	if(isset($_REQUEST["for_user"])){
		$for_user = $_REQUEST["for_user"];
	}


	include_once "config.php";

	$out = array();

	if(is_null($for_user)){
		$current_user = get_from_session("current_user");
		if(is_null($current_user)){
			$out["message"] = "You must login to access this page";
			$out["status"] = false;
			echo json_encode($out);
			return;
		}

		$for_user = $current_user["id"];
	}
	

	$sql = "select day(blocked_date) as day from calendar where user_id = ? " 
		. "and month(blocked_date)=? and year(blocked_date)=?";

	$data = R::getAll($sql, 
		array($for_user, $selected_month, $selected_year));
	$ar = array();
	foreach ($data as $key => $value) {
		array_push($ar, $value["day"]);
	}

	$out["days"] = $ar;
	$out["status"] = true;
	$out["message"] = "Requested data sent successfully";
	echo json_encode($out, JSON_NUMERIC_CHECK);
