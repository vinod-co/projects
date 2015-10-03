<?php
	// change_password_action.php
	include_once "config.php";
	include_once "functions.php";

	store_admin_password("admin123");
	echo "Admin password reset to 'admin123'";
