<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/assets/php/FMUtil.inc.php");
header("Content-Type: application/json");
$items = FileMaker::getDatabaseNames($_GET["username"], $_GET["password"]);
die(json_encode($items));
