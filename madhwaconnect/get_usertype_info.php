<?php

	// get_usertype_info.php

	include_once "config.php";

	$id = null;

	if(isset($_REQUEST["id"])){
		$id = $_REQUEST["id"];
	}

	$out = array();

	if($id==null){
		$out["status"] = false;
		$out["message"] = "Id is missing.";
	}
	else{
		$sql = "select * from usertypes where id=?";
		$data = R::getRow($sql, array($id));
		$out["status"] = true;
		$data["fields"] = explode(",", $data["fields"]);
		$out["data"] = $data;
	}

	echo json_encode($out, JSON_NUMERIC_CHECK);
