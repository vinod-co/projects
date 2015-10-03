<?php 
include_once "config.php";
header("Content-type: application/json");

$cellphone = $_REQUEST["cellphone"];
$sql = <<<EOT
select count(*) as count from users 
where ? in (cellphone, another_cellphone, landline, another_landline)
EOT;

$data = R::getRow($sql, array($cellphone));

$out = array("status"=>true);
if($data["count"]!=0){
	$out = array("status"=>false);
}

echo json_encode($out);