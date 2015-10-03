<?php
	// check_for_auto_login.php
	
	if(isset($_COOKIE["token"])){
		include_once "config.php";
		$sql = "select * from users where id=?";
		$data = R::getRow($sql, array($_COOKIE["token"]));
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$_SESSION["current_user"] = $data;
	}