<?php 
include_once "config.php";

header("Content-type: application/json");

$username = $_REQUEST["username"];
//$username = "vinod";

$sql = "select count(*) as count from users where username = ?";
$data = R::getRow($sql, array($username));

//print_r($data);

$out = array("status"=>true);
if($data["count"]!=0){
	$out = array("status"=>false);
}

echo json_encode($out);