<?php

	// post_message.php

	$message_text = null;
	$to_id = null;
	$thread_id = null;

	if(isset($_REQUEST["message_text"])){
		$message_text = $_REQUEST["message_text"];
	}

	if(isset($_REQUEST["to_id"])){
		$to_id = $_REQUEST["to_id"];
	}

	if(isset($_REQUEST["thread_id"])){
		$thread_id = $_REQUEST["thread_id"];
	}

	$response_code = null;
	if(isset($_REQUEST["response_code"])){
		$response_code = $_REQUEST["response_code"];
	}

	$sr_id = null;
	if(isset($_REQUEST["sr_id"])){
		$sr_id = $_REQUEST["sr_id"];
	}


	$out = array();

	if(is_null($message_text)){
		$out["status"] = false;
		$out["message"] = "Message text is missing.";
		echo json_encode($out, JSON_NUMERIC_CHECK);
		return;
	}

	$out["thread_id"] = $thread_id;

	include_once "config.php";
	if(is_null($thread_id)){
		$data = R::getCol("select max(thread_id)+1 as new_thread_id from messages");
		$thread_id = $data[0];
		if(is_null($thread_id)){
			$thread_id = 1;
		}
	}
	$current_user = get_from_session("current_user");

	$data = R::dispense("messages");
	$data->message_text = $message_text;
	$data->message_sent_datetime = date("Y-m-d h:i:s");
	$data->to_id = $to_id; 
	$data->thread_id = $thread_id;
	$data->from_id = $current_user["id"];

	R::store($data);

	if($response_code!=null){
		$response = R::dispense("srresponses");
		$response->sr_id = $sr_id;
		$response->response_from_id = $current_user["id"];
		$response->response_code = $response_code;
		$response->thread_id = $thread_id;
		R::store($response);
	}
	
	$out["status"] = true;
	$out["message"] = "Message posted successfully!";

	echo json_encode($out, JSON_NUMERIC_CHECK);