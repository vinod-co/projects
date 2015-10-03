<?php 
include_once "config.php";
header("Content-type: application/json");

$email = $_REQUEST["email"];
$sql = <<<EOT
select count(*) as count from users 
where ? in (email, another_email)
EOT;

$data = R::getRow($sql, array($email));

$out = array("status"=>true);
if($data["count"]!=0){
	$out = array("status"=>false);
}

echo json_encode($out);