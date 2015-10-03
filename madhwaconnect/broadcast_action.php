<?php

	// broadcast_action.php

include "config.php";

$target_usertype = null;
$message = null;

if(isset($_POST["target_usertype"])){
	$target_usertype = $_POST["target_usertype"];
}
if(isset($_POST["message"])){
	$message = $_POST["message"];
}


if($message==null || $message==""){
	store_in_session("message", "You can't send an empty message");
	header("Location: ./broadcast.php");
}
else {
	$data = R::getCol("select max(thread_id)+1 as new_thread_id from messages");
	$thread_id = $data[0];
	if(is_null($thread_id)){
		$thread_id = 1;
	}

	$sql = "insert into messages (from_id, to_id, message_sent_datetime, message_text, thread_id) values(0, ?,?,?,?)";

	$param = 1;
	$sql1 = "select id from users where 1=?";
	if($target_usertype!=-1){
		$sql1 = "select id from users where usertype=?";
		$param = $target_usertype;	
	}

	
	$data = R::getAll($sql1, array($param));
	foreach ($data as $value) {
		R::exec($sql, array($value["id"], date("Y-m-d h:i:s"), $message, $thread_id++));
	}

	store_in_session("message", "Message was broadcast successfully");
	header("Location: ./broadcast.php");
}