<?php

	include_once "config.php";
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$username = $_REQUEST["username_email"];
	$password = $_REQUEST["password"];

	$out = array();

	if($username=="administrator"){
		if(!is_admin_password($password)){
			$out["status"] = false;
			$out["message"] = "Invalid password for administrator";
			echo json_encode($out);
			return;
		}
		else{
			$out["status"] = true;
			$out["redirect"] = "admin.php";

			$data = array();
			$data["firstname"] = "Administrator";
			$data["lastname"] = "";
			$data["profile_picture"] = "";
			$data["username"] = "administrator";
			$data["usertype"] = 0;
			store_in_session("current_user", $data);
			echo json_encode($out);
			return;
		}
	}

	$sql = "select * from users where ? in (username, email, another_email) and password=md5(?)";
	$data = R::getRow($sql, array($username, $password));
	if(count($data)==0){
		$out["status"] = false;
		$out["message"] = "Invalid username/password";
		echo json_encode($out);
	}
	else{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$_SESSION["current_user"] = $data;
		$out["status"] = true;
		$out["message"] = "";
		
		echo json_encode($out);
		if(isset($_POST["keep_me_logged_in"])){
			// user wants to be remembered by the browser
			// send a kookie
			setcookie("token", $data["id"], time()+365*24*60*60);
		}
		else{

		}
		return;
	}