<?php
// config.php

	require_once "readbeanphp/rb.php";
	require_once "functions.php";
	
	date_default_timezone_set('Asia/Calcutta');
	$db_username = "root";
	$db_password = "";
	$db_name = "madhwaconnect";
	$db_host = "localhost";


	// $db_username = "madhwaconnect";
	// $db_password = "Welcome#123";
	// $db_name = "madhwaconnect";
	// $db_host = "madhwaconnect.db.7044306.hostedresource.com";

	R::setup("mysql:host={$db_host};dbname={$db_name}",$db_username,$db_password);

	$types_map = array();
	$types_map[1] = "Consumers";
	$types_map[2] = "Pandits/Purohits";
	$types_map[3] = "Food caterers";
	$types_map[4] = "Flower decoraters";
	$types_map[5] = "Musicians";
	$types_map[6] = "Wedding hall owners";
?>