<?php

	// save_category.php

	include_once "config.php";

	$current_user = get_from_session("current_user");

	if(is_null($current_user)){
		store_in_session("message", "You must login to access this page");
		header("Location: index.php");
		return;
	}

	// TODO
	// check for admin role

	$usertype = null;
	$category = null;
	$services = null;

	if(isset($_REQUEST["usertype"])){
		$usertype = $_REQUEST["usertype"];
	}
	
	if(isset($_REQUEST["category"])){
		$category = $_REQUEST["category"];
	}
	
	if(isset($_REQUEST["services"])){
		$services = $_REQUEST["services"];
	}

	$out = array();

	if($usertype == null || $category == null || $services == null){
		$out["status"] = false;
		$out["message"] = "Usertype or category or services missing";
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}

	$new_category = R::dispense("categories");
	$new_category->category = $category;
	$new_category->usertype = $usertype;
	try{
		R::store($new_category);

		$services_array = explode("\n", $services);
		foreach($services_array as $service){
			$service = trim($service);

			if($service==""){
				continue;
			}
			$new_service = R::dispense("services");
			$new_service->service = trim($service);
			$new_service->category_id = $new_category->id;
			R::store($new_service);
		}

		$out["status"] = true;
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}
	catch(Exception $e){
		$out["status"] = false;
		$out["message"] = "The category already exists.";
		$out["exception_message"] = $e->getMessage();
		echo json_encode($out, JSON_NUMERIC_CHECK);
	}
	