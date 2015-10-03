<?php
	$inputs = array();

	$utc_name="UTC_01";
	$input = "\"9, 69, 40, 31, 18, 69\" \"5, 75, 18, 18, 14, 82\"";
	$output = "[5, 69, 18, 18, 14, 69]";

	$var = array(
		"input"=>"",
		"cliInput"=>"{$input}",
		"output"=>"{$output}\n",
		"type"=>"CLI"
		);

	$another_var = array(
		"input"=>"",
		"cliInput"=>"{$input}",
		"output"=>"{$output}\n",
		"type"=>"CLI"
		);
	$var1 = array("UTC_01"=>$var);
	$var2 = array("UTC_02"=>$another_var);
	echo json_encode(array($var1, $var2));
?>
{
    "checkName": "UTC_01",
    "checkType": "BlackBoxTest",
    "include": "true",
    "group": "blackboxtests",
    "visible": "all",
    "penalty": "",
    "rule": {
        "input": "",
        "cliInput": "\"9, 69, 40, 31, 18, 69\" \"5, 75, 18, 18, 14, 82\"",
        "output": "[5, 69, 18, 18, 14, 69]\n",
        "type": "CLI"
    },
    "score": ""
},
{
    "checkName": "Null input",
    "checkType": "BlackBoxTest",
    "include": "true",
    "group": "blackboxtests",
    "visible": "all",
    "penalty": "",
    "rule": {
        "input": "",
        "cliInput": "\"48, 75, 9, 36, 1, 38\" null",
        "output": "[48, 75, 9, 36, 1, 38]\n",
        "type": "CLI"
    },
    "score": ""
}