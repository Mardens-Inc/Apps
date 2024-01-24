<?php
$_ENV["APP_PATH"] = $_SERVER['DOCUMENT_ROOT'] . "/apps/IT-Computers";
require_once($_ENV["APP_PATH"] . '/assets/php/inc/ITComputers.inc.php');
header("Content-Type: application/json");

$computers = new ITComputers();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (isset($_GET["mirror"])) {
        $response = $computers->loadFromFileMaker();
        if ($response) {
            http_response_code(200);
            die(json_encode(["message" => "Mirror successful!"]));
        } else {
            http_response_code(500);
            die(json_encode(["message" => "Failed to mirror!"]));
        }
    }

    if (isset($_GET["unique"])) {
        $unique = $_GET["unique"];
        if ($unique === "all") {
            http_response_code(200);
            die(json_encode(["locations" => $computers->getUniqueLocations(), "make" => $computers->getUniqueMake()]));
        } else if ($unique === "locations") {
            $locations = $computers->getUniqueLocations();
            if ($locations) {
                http_response_code(200);
                die(json_encode(["locations" => $locations]));
            } else {
                http_response_code(500);
                die(json_encode(["message" => "Failed to get locations!"]));
            }
        } else if ($unique === "make") {
            $make = $computers->getUniqueMake();
            if ($make) {
                http_response_code(200);
                die(json_encode(["make" => $make]));
            } else {
                http_response_code(500);
                die(json_encode(["message" => "Failed to get make!"]));
            }
        } else {
            http_response_code(400);
            die(json_encode(["message" => "Invalid unique"]));
        }
    }

    if (isset($_GET["enum"])) {
        $enum = $_GET["enum"];
        if ($enum === "all") {
            http_response_code(200);
            die(json_encode(["operating_systems" => $computers->getOperatingSystems(), "device_types" => $computers->getDeviceTypes(), "conditions" => $computers->getConditions()]));
        } else if ($enum === "conditions") {
            http_response_code(200);
            die(json_encode(["conditions" => $computers->getConditions()]));
        } else if ($enum === "device_types") {
            http_response_code(200);
            die(json_encode(["device_types" => $computers->getDeviceTypes()]));
        } else if ($enum === "operating_systems") {
            http_response_code(200);
            die(json_encode(["operating_systems" => $computers->getOperatingSystems()]));
        } else {
            http_response_code(400);
            die(json_encode(["message" => "Invalid enum"]));
        }
    }

    // Get specific computer
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        try {

            $response = $computers->getComputer($id);
        } catch (Exception $e) {
            http_response_code(404);
            die(json_encode(array("message" => "Failed to get computer", "error" => $e->getMessage())));
        }
        if ($response) {
            http_response_code(200);
            die(json_encode($response));
        } else {
            http_response_code(404);
            die(json_encode(array("message" => "Computer not found")));
        }
    }

    // Get computer count
    if (isset($_GET["count"])) {
        http_response_code(200);
        die(json_encode(["count" => $computers->getComputerCount()]));
    }

    // search
    if (isset($_GET["search"])) {
        $search = $_GET["search"];
        $limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
        $offset = isset($_GET["offset"]) ? $_GET["offset"] : 0;
        $ascending = isset($_GET["ascending"]) ? $_GET["ascending"] : true;
        $computers = $computers->searchComputers($search, $limit, $offset, $ascending);
        http_response_code(200);
        die(json_encode(["computers" => $computers, "count" => count($computers)]));
    }

    // Filter computers
    if (isset($_GET["filter"])) {
        $filter = json_decode($_GET["filter"], true);
        $limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
        $offset = isset($_GET["offset"]) ? $_GET["offset"] : 0;
        $ascending = isset($_GET["ascending"]) ? $_GET["ascending"] : true;
        $computers = $computers->filterComputers($filter, $limit, $offset, $ascending);
        http_response_code(200);
        die(json_encode(["computers" => $computers, "count" => count($computers)]));
    }

    die(json_encode($computers->getComputers()));
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $body = file_get_contents("php://input");
    $data = Computer::fromJSON($body);

    if ($data && $data instanceof Computer) {
        try {

            $response = $computers->addComputer($data);
            if ($response && $response instanceof Computer) {
                http_response_code(201);
                die(json_encode($response));
            } else {
                http_response_code(500);
                die(json_encode(array("message" => "Failed to add computer")));
            }
        } catch (Exception $e) {
            http_response_code(500);
            die(json_encode(array("message" => "Failed to add computer", "error" => $e->getMessage())));
        }
    } else {
        $body = json_decode($body, true);
        $missingField = [];

        if (!isset($body["asset_number"])) {
            array_push($missingField, "asset_number");
        }
        if (!isset($body["make"])) {
            array_push($missingField, "make");
        }
        if (!isset($body["model"])) {
            array_push($missingField, "model");
        }
        if (!isset($body["condition"])) {
            array_push($missingField, "condition");
        }
        if (!isset($body["device_type"])) {
            array_push($missingField, "device_type");
        }
        if (!isset($body["operating_system"])) {
            array_push($missingField, "operating_system");
        }
        if (!isset($body["primary_user"])) {
            array_push($missingField, "primary_user");
        }
        if (!isset($body["location"])) {
            array_push($missingField, "location");
        }
        if (!isset($body["additional_information"])) {
            array_push($missingField, "additional_information");
        }
        if (!isset($body["notes"])) {
            array_push($missingField, "notes");
        }

        http_response_code(400);
        die(json_encode(array("message" => "Invalid JSON", "missing_fields" => $missingField)));
    }
} else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $data = Computer::fromJSON(file_get_contents("php://input"));

    if ($data && $data instanceof Computer) {
        $response = $computers->updateComputer($data);
        if ($response) {
            http_response_code(200);
            die(json_encode(["success" => $response]));
        } else {
            http_response_code(500);
            die(json_encode(array("message" => "Failed to update computer")));
        }
    } else {
        http_response_code(400);
        die(json_encode(array("message" => "Invalid JSON")));
    }
} else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $response = $computers->deleteComputer($id);
        if ($response) {
            http_response_code(200);
            die(json_encode(["message" => "Computer deleted successfully!"]));
        } else {
            http_response_code(500);
            die(json_encode(array("message" => "Failed to delete computer")));
        }
    }
}
http_response_code(400);
die(json_encode(array("message" => "Invalid request")));
