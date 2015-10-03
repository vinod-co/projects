<?php
	// functions.php

function get_services_for_user($userid){
	$sql = "select serviceid from services s join userservices us on s.id=us.serviceid where userid=?";
	$data = R::getAll($sql, array($userid));
	$arr = array();
	foreach ($data as $value) {
		array_push($arr, $value["serviceid"]);
	}
	return $arr;
}

function get_unread_messages_count($id){
	$sql = "select count(*) as cnt from messages where is_read = 0 and to_id = ?";
	$row = R::getRow($sql, array($id));
	return $row["cnt"];
}

function get_header_value($key){
	foreach (apache_request_headers() as $name => $value) {
	    if($name == $key) return $value;
	}
	return null;
}
function generate_password(){
	$lchars = "abcdefghijklmnopqrstuvwxyz";
	$uchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$digits = "0123456789";
	$spl = "!@#$%^&*()";

	$ar = array($lchars, $uchars, $digits, $spl);
	$pass = "";
	for($i=0; $i<4; $i++){
		for($j=0; $j<4; $j++){
			$seed1 = rand(0, 3);
			$src = $ar[$seed1];
			$len = strlen($src);
			$seed2 = rand(0, $len-1);
			$pass .= substr($src, $seed2, 1);
		}
	}	
	return $pass;
}

function get_usertype($id){
	$sql = "select typename from usertypes where id = ?";
	$data = R::getCell($sql, array($id));
	return $data;
}

function is_enduser($id){
	$sql = "select not_listed_in_search from usertypes where id = (select usertype from users where id = ?)";
	require_once "config.php";
	$data = R::getRow($sql, array($id));
	return $data["not_listed_in_search"]==1? 1: 0;
}
function remove_from_session($key){
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION[$key])){
		unset($_SESSION[$key]);
	}
}

function store_in_session($key, $value){
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	$_SESSION[$key] = $value;
}

function get_from_session($key){
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION[$key])){
		return $_SESSION[$key];
	}
	return null;
}

function is_admin_password($password){
	$stored_password = file_get_contents("admin_password.dat");
	return md5($password) == $stored_password;
}

// store_admin_password("admin123");
function store_admin_password($password){
	file_put_contents("admin_password.dat", md5($password));
}

function send_email($data){
	require_once('phpmailer/class.phpmailer.php');
	$mail = new PHPMailer(); 

	if(isset($data["reply_to_email"])){
		$mail->AddReplyTo($data["reply_to_email"], $data["reply_to_name"]);
	}
	
	if(isset($data["from_email"])){
		$mail->SetFrom($data["from_email"], $data["from_name"]);
	}
	
	$mail->AddAddress($data["email_id"]);

	if(isset($data["cc_email"])){
		$mail->AddCC($data["cc_email"], $data["cc_name"]);	
	}
	if(isset($data["bcc_email"])){
		$mail->AddBCC($data["bcc_email"], $data["bcc_name"]);
	}
	if(isset($data["subject"])){
		$mail->Subject = $data["subject"];	
	}
	
	$mail->MsgHTML($data["content"]);

	if($mail->Send()) {
		return true;
	}
	else {
		return false;
	}
}