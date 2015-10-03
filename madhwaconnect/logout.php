<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION["current_user"])){
		unset($_SESSION["current_user"]);
		unset($_SESSION["login_error"]);
		setcookie("token", "", time()-100);
	}
header("Location: http://madhwaconnect.com/");