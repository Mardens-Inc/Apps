<?php
$method = $_SERVER['REQUEST_METHOD'];
require_once($_SERVER["DOCUMENT_ROOT"] . "/assets/php/FMUtil.inc.php");
header("Content-Type: application/json");
$databaseNames = FileMaker::getDatabaseNames($_GET["username"], $_GET["password"]);
$result = [];
foreach ($databaseNames as $name) {
    try {
        $items = FileMaker::getDatabaseLayouts($_GET["username"], $_GET["password"], $name);
        $result[$name] = ["item" => $items, "success" => true];
    } catch (Exception $e) {
        $result[$name] = ["message" => json_decode($e->getMessage()), "success" => false];
        continue;
    }
}

die(json_encode($result));
