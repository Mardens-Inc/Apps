<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/assets/php/FMUtil.inc.php");
header("Content-Type: application/json");
$items = FileMaker::getDatabaseLayouts($_GET["username"], $_GET["password"], $_GET["database"]);
die(json_encode($items));
