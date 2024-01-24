<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/assets/php/FMUtil.inc.php");
header("Content-Type: application/json");

$config = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/config.json"), true);
$username = $config["filemaker"]["username"];
$password = $config["filemaker"]["password"];

$items = FileMaker::getDatabaseLayouts($username, $password, $_GET["database"]);
die(json_encode($items));
