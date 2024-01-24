<?php
$method = $_SERVER['REQUEST_METHOD'];
header("Content-Type: application/json");
require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/php/Apps.inc.php";
$apps = new Apps();
switch ($method) {
    case "GET":
        die(json_encode($apps->getApps()));
    case "POST":
        break;
    case "DELETE":
        break;
    default:
        http_response_code(405);
        die(json_encode(["error" => "Invalid Method"]));
}
