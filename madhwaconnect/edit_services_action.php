<?php

	// edit_services_action.php
include_once "config.php";
$current_user = get_from_session("current_user");

if(isset($_POST["service"])){
	$services = $_POST["service"];
	$sql = "delete from userservices where userid=?";
	R::exec($sql, array($current_user["id"]));

	if(!empty($services)){
		foreach($services as $service){
			$userservice = R::dispense("userservices");
			$userservice->userid = $current_user["id"];
			$userservice->serviceid = $service;
			R::store($userservice);
		}		
	}
}

header("Location: edit_services.php");