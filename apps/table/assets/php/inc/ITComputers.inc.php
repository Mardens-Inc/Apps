<?php
$_ENV["APP_PATH"] = $_SERVER['DOCUMENT_ROOT'] . "/apps/IT-Computers";
enum Condition: int
{
    case New = 0;
    case Good = 1;
    case Used = 2;
    case Refurbished = 3;
    case Broken = 4;
}

enum DeviceType: int
{
    case Desktop = 0;
    case Laptop = 1;
    case Tablet = 2;
    case Phone = 3;
    case Server = 4;
    case Printer = 5;
    case Other = 6;
}

enum OperatingSystem: int
{
    case Windows = 0;
    case MacOS = 1;
    case Linux = 2;
    case ChromeOS = 3;
    case Android = 4;
    case IOS = 5;
    case Umix = 6;
    case Other = 7;
}

class Computer
{
    public int $id;
    public int $asset_number;
    public string $make;
    public string $model;
    public Condition $condition;
    public DeviceType $device_type;
    public OperatingSystem $operating_system;
    public string $primary_user;
    public string $location;
    public mixed $additional_information;
    public string $notes;
    public DateTime $created_date;
    public DateTime $modified_date;

    function __construct(int $asset_number, string $make, string $model, Condition $condition, DeviceType $device_type, OperatingSystem $operatingSystem, string $primary_user, string $location, mixed $additional_information, string $notes)
    {
        $this->id = 0;
        $this->asset_number = $asset_number;
        $this->make = $make;
        $this->model = $model;
        $this->condition = $condition;
        $this->device_type = $device_type;
        $this->operating_system = $operatingSystem;
        $this->primary_user = $primary_user;
        $this->location = $location;
        $this->additional_information = $additional_information;
        $this->notes = $notes;
        $this->created_date = new DateTime();
        $this->modified_date = new DateTime();
    }

    /**
     * This function returns a JSON representation of the Computer object.
     * @return string The JSON representation of the Computer object, or an boolean false if the JSON encoding failed.
     */
    public static function fromJSON(string|array $json): Computer|bool
    {
        if (is_string($json))
            $data = json_decode($json, true);
        else if (is_array($json))
            $data = $json;
        else return false;
        if ($data) {
            try {
                $condition = match ($data["condition"]) {
                    0 => Condition::New,
                    1 => Condition::Good,
                    2 => Condition::Used,
                    3 => Condition::Refurbished,
                    4 => Condition::Broken,
                    default => false
                };

                $deviceType = match ($data["device_type"]) {
                    0 => DeviceType::Desktop,
                    1 => DeviceType::Laptop,
                    2 => DeviceType::Tablet,
                    3 => DeviceType::Phone,
                    4 => DeviceType::Server,
                    5 => DeviceType::Printer,
                    6 => DeviceType::Other,
                    default => false
                };

                $operatingSystem = match ($data["operating_system"]) {
                    0 => OperatingSystem::Windows,
                    1 => OperatingSystem::MacOS,
                    2 => OperatingSystem::Linux,
                    3 => OperatingSystem::ChromeOS,
                    4 => OperatingSystem::Android,
                    5 => OperatingSystem::IOS,
                    6 => OperatingSystem::Umix,
                    7 => OperatingSystem::Other,
                    default => false
                };

                if (!$condition || !$deviceType || !$operatingSystem) return false;

                $additional_information = is_string($data["additional_information"]) ? json_decode($data["additional_information"]) : $data["additional_information"];

                $computer = new Computer(
                    $data["asset_number"],
                    $data["make"],
                    $data["model"],
                    $condition,
                    $deviceType,
                    $operatingSystem,
                    $data["primary_user"],
                    $data["location"],
                    $additional_information,
                    $data["notes"]
                );
                if (isset($data["id"]))
                    $computer->id = $data["id"];
                if (isset($data["created_date"]))
                    $computer->created_date = new DateTime($data["created_date"]);
                if (isset($data["modified_date"]))
                    $computer->modified_date = new DateTime($data["modified_date"]);

                return $computer;
            } catch (Exception) {

                return false;
            }
        }
        return false;
    }

    public static function parseOperatingSystem(string $operating_system): OperatingSystem
    {
        $operating_system = strtolower($operating_system);
        if (strpos($operating_system, "windows") !== false) {
            return OperatingSystem::Windows;
        } else if (strpos($operating_system, "mac") !== false) {
            return OperatingSystem::MacOS;
        } else if (strpos($operating_system, "linux") !== false) {
            return OperatingSystem::Linux;
        } else if (strpos($operating_system, "chrome") !== false) {
            return OperatingSystem::ChromeOS;
        } else if (strpos($operating_system, "android") !== false) {
            return OperatingSystem::Android;
        } else if (strpos($operating_system, "ios") !== false) {
            return OperatingSystem::IOS;
        } else if (strpos($operating_system, "umix") !== false) {
            return OperatingSystem::Umix;
        }
        return OperatingSystem::Other;
    }

    public static function parseCondition(string $condition): Condition
    {
        $condition = strtolower($condition);
        if (strpos($condition, "new") !== false) {
            return Condition::New;
        } else if (strpos($condition, "good") !== false) {
            return Condition::Good;
        } else if (strpos($condition, "used") !== false) {
            return Condition::Used;
        } else if (strpos($condition, "refurb") !== false) {
            return Condition::Refurbished;
        } else if (strpos($condition, "broken") !== false) {
            return Condition::Broken;
        }
        return Condition::Good;
    }

    public static function parseDeviceType(string $device_type): DeviceType
    {
        $device_type = strtolower($device_type);
        if (strpos($device_type, "desktop") !== false) {
            return DeviceType::Desktop;
        } else if (strpos($device_type, "laptop") !== false) {
            return DeviceType::Laptop;
        } else if (strpos($device_type, "tablet") !== false) {
            return DeviceType::Tablet;
        } else if (strpos($device_type, "phone") !== false) {
            return DeviceType::Phone;
        } else if (strpos($device_type, "server") !== false) {
            return DeviceType::Server;
        } else if (strpos($device_type, "printer") !== false) {
            return DeviceType::Printer;
        } else if (strpos($device_type, "other") !== false) {
            return DeviceType::Other;
        }
        return DeviceType::Other;
    }
}

class ITComputers
{
    private $db;
    /**
     * The constructor for the ITComputers class.
     * It connects to the database and creates the `computers` table if it doesn't exist.
     */
    function __construct()
    {
        date_default_timezone_set('America/New_York');
        require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/php/connections.inc.php";
        $this->db = DB_Connect::connect();

        // Create tables if they don't exist
        $this->db->query("CREATE TABLE IF NOT EXISTS `computers` 
        (`id` INT NOT NULL AUTO_INCREMENT,
        `asset_number` INT NOT NULL,
        `make` VARCHAR(255) NOT NULL,
        `model` VARCHAR(255) NULL DEFAULT NULL,
        `condition` TINYINT NOT NULL DEFAULT 0,
        `device_type` TINYINT NOT NULL DEFAULT 0,
        `operating_system` TINYINT NOT NULL,
        `available` TINYINT NOT NULL DEFAULT 1,
        `primary_user` VARCHAR(255) NOT NULL,
        `location` VARCHAR(255) NOT NULL,
        `additional_information` JSON NOT NULL,
        `notes` TEXT NOT NULL,
        `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `modified_date` TIMESTAMP NULL DEFAULT NULL,
        PRIMARY KEY (`id`))
        ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    /**
     * This function retrieves a computer from the database by its id.
     *
     * @param int $id The id of the computer to retrieve.
     * @return Computer The computer object.
     * @throws Exception If no computer is found with the provided id, or if more than one computer is found with the same id.
     */
    function getComputer(int $id): Computer|bool
    {
        // Prepare a SQL statement to select a computer from the `computers` table by its `id`.
        $stmt = $this->db->prepare("SELECT * FROM `computers` WHERE `id` = ?");

        // Bind the `id` parameter to the prepared statement.
        $stmt->bind_param("i", $id);

        // Execute the prepared statement.
        $stmt->execute();

        // Get the result of the executed statement.
        $result = $stmt->get_result();

        // If no rows were returned, throw an exception.
        if ($result->num_rows === 0) {
            throw new Exception('No computer found with the provided id');
        }

        // If more than one row was returned, throw an exception.
        if ($result->num_rows > 1) {
            throw new Exception('More than one computer found with the same id. Id should be unique.');
        }

        // Fetch the first (and only) row of the result set.
        $row = $result->fetch_assoc();


        $computer = Computer::fromJSON($row);

        if ($computer instanceof Computer) {
            // Return the Computer object.
            return $computer;
        }
        return false;
    }

    /**
     * This function retrieves all computers from the database.
     *
     * @return array An array of Computer objects.
     */
    function getComputers(): array
    {
        // Prepare a SQL statement to select all rows from the `computers` table.
        $stmt = $this->db->prepare("SELECT * FROM `computers`");

        // Execute the prepared statement.
        $stmt->execute();

        // Get the result of the executed statement.
        $result = $stmt->get_result();

        // Initialize an empty array to hold the computers.
        $computers = array();

        // Loop through each row in the result set.
        while ($row = $result->fetch_assoc()) {
            $computer = Computer::fromJSON($row);

            // Add the Computer object to the computers array.
            array_push($computers, $computer);
        }

        // Return the array of Computer objects.
        return $computers;
    }

    /**
     * This function adds a new computer to the database.
     *
     * @param Computer $computer The computer object to add.
     * @return bool Returns true if the operation was successful, false otherwise.
     */
    function addComputer(Computer $computer): Computer|bool
    {
        $stmt = $this->db->prepare("INSERT INTO `computers` (`asset_number`, `make`, `model`, `condition`, `device_type`, `operating_system`, `primary_user`, `location`, `additional_information`, `notes`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $condition = $computer->condition->value;
        $device_type = $computer->device_type->value;
        $operating_system = $computer->operating_system->value;
        $additional_information = json_encode($computer->additional_information);
        $stmt->bind_param("issiiissss", $computer->asset_number, $computer->make, $computer->model, $condition, $device_type, $operating_system, $computer->primary_user, $computer->location, $additional_information, $computer->notes);
        $stmt->execute();
        if ($stmt->affected_rows <= 0) return false;
        $id = $stmt->insert_id;
        return $this->getComputer($id);
    }

    /**
     * This function updates an existing computer in the database.
     *
     * @param Computer $computer The computer object to update.
     * @return bool Returns true if the operation was successful, false otherwise.
     */
    function updateComputer(Computer $computer): bool
    {
        $stmt = $this->db->prepare("UPDATE `computers` SET `asset_number` = ?, `make` = ?, `model` = ?, `condition` = ?, `device_type` = ?, `operating_system` = ?, `primary_user` = ?, `location` = ?, `additional_information` = ?, `notes` = ?, `modified_date` = ? WHERE `id` = ?");
        $condition = $computer->condition->value;
        $device_type = $computer->device_type->value;
        $operating_system = $computer->operating_system->value;
        $additional_information = json_encode($computer->additional_information);
        $modified_date = date("Y-m-d H:i:s");
        $stmt->bind_param("isssiiissssi", $computer->asset_number, $computer->make, $computer->model, $condition, $device_type, $operating_system, $computer->primary_user, $computer->location, $additional_information, $computer->notes, $modified_date, $computer->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * This function deletes a computer from the database.
     *
     * @param int $id The id of the computer to delete.
     * @return bool Returns true if the operation was successful, false otherwise.
     */
    function deleteComputer(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `computers` WHERE `id` = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * This function returns the total count of computers in the database.
     *
     * @return int The total count of computers.
     */
    function getComputerCount(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM `computers`");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row["COUNT(*)"];
    }


    /**
     * Searches for computers in the database based on a query string.
     * @param string $query The query string to search for.
     * @param int $limit The maximum number of results to return.
     * @param int $offset The number of results to skip.
     * @param bool $ascending Whether to sort the results in ascending or descending order.
     * @return array An array of Computer objects that match the search criteria.
     * @example searchComputers("Dell", 10, 0, true) returns an array of the first 10 computers with "Dell" in any of the columns, sorted by asset number in ascending order.
     */
    function searchComputers(string $query, int $limit, int $offset, bool $ascending): array
    {
        // Prepare a SQL statement to select all columns from the `computers` table where any of the specified columns
        // contain the query string. The results are ordered by `asset_number` in either ascending or descending order,
        // and the number of results is limited with an offset for pagination.
        $stmt = $this->db->prepare("SELECT * FROM `computers` WHERE `asset_number` LIKE ? OR `make` LIKE ? OR `model` LIKE ? OR `primary_user` LIKE ? OR `location` LIKE ? OR `notes` LIKE ? ORDER BY `asset_number` " . ($ascending ? "ASC" : "DESC") . " LIMIT ? OFFSET ?");

        // The query string is wrapped in '%' to allow for partial matches in the SQL LIKE clause.
        $query = "%" . $query . "%";

        // Bind the parameters to the prepared statement. The same query string is used for all LIKE clauses,
        // and the limit and offset are also bound to the statement.
        $stmt->bind_param("ssssssii", $query, $query, $query, $query, $query, $query, $limit, $offset);

        // Execute the prepared statement.
        $stmt->execute();

        // Get the result of the executed statement.
        $result = $stmt->get_result();

        // Initialize an empty array to hold the Computer objects.
        $computers = array();

        // Loop through each row in the result set.
        while ($row = $result->fetch_assoc()) {

            $computer = Computer::fromJSON($row);

            // Add the Computer object to the array.
            array_push($computers, $computer);
        }

        // Return the array of Computer objects.
        return $computers;
    }

    /**
     * Filters computers in the database based on an array of filters.
     * @param array $filters An array of filters to apply to the query.
     * @param int $limit The maximum number of results to return.
     * @param int $offset The number of results to skip.
     * @param bool $ascending Whether to sort the results in ascending or descending order.
     * @return array An array of Computer objects that match the filter criteria.
     * @example filterComputers([["column" => "make", "value" => "Dell"], ["column" => "condition", "value" => 1]], 10, 0, true) returns an array of the first 10 computers that have "Dell" in the "make" column and "1" in the "condition" column, sorted by asset number in ascending order.
     */
    public function filterComputers(array $filters, int $limit, int $offset, bool $ascending): array
    {
        // Initialize the query string with the SELECT statement.
        $query = "SELECT * FROM `computers` WHERE ";

        // Initialize an empty array to hold the parameters for the prepared statement.
        $params = array();

        // Loop through each filter in the filters array.
        foreach ($filters as $filter) {
            // Append the filter's column and a placeholder to the query string.
            $query .= "`" . $filter["column"] . "` = ? AND ";
            // Add the filter's value to the parameters array.
            array_push($params, $filter["value"]);
        }

        // Remove the trailing " AND " from the query string.
        $query = substr($query, 0, -5);

        // Append the ORDER BY and LIMIT clauses to the query string.
        $query .= " ORDER BY `asset_number` " . ($ascending ? "ASC" : "DESC") . " LIMIT ? OFFSET ?";

        // Add the limit and offset to the parameters array.
        array_push($params, $limit);
        array_push($params, $offset);

        // Prepare the SQL statement.
        $stmt = $this->db->prepare($query);

        // Bind the parameters to the prepared statement.
        $stmt->bind_param(str_repeat("s", count($params)), ...$params);

        // Execute the prepared statement.
        $stmt->execute();

        // Get the result of the executed statement.
        $result = $stmt->get_result();

        // Initialize an empty array to hold the Computer objects.
        $computers = array();

        // Loop through each row in the result set.
        while ($row = $result->fetch_assoc()) {
            $computer = Computer::fromJSON($row);
            // Add the Computer object to the computers array.
            array_push($computers, $computer);
        }

        // Return the array of Computer objects.
        return $computers;
    }

    public function getUniqueLocations(){
        $stmt = $this->db->prepare("SELECT DISTINCT `location` FROM `computers`");
        $stmt->execute();
        $result = $stmt->get_result();
        $locations = array();
        while ($row = $result->fetch_assoc()) {
            array_push($locations, $row["location"]);
        }
        return $locations;
    }

    public function getUniqueMake(){
        $stmt = $this->db->prepare("SELECT DISTINCT `make` FROM `computers`");
        $stmt->execute();
        $result = $stmt->get_result();
        $makes = array();
        while ($row = $result->fetch_assoc()) {
            array_push($makes, $row["make"]);
        }
        return $makes;
    }

    public function getConditions(){
        $names = array_column(Condition::cases(), "name");
        $values = array_column(Condition::cases(), "value");
        
        // map names to values
        return array_combine($names,$values);
    }

    public function getDeviceTypes(){
        $names = array_column(DeviceType::cases(), "name");
        $values = array_column(DeviceType::cases(), "value");
        
        // map names to values
        return array_combine($names,$values);
    }

    public function getOperatingSystems(){
        $names = array_column(OperatingSystem::cases(), "name");
        $values = array_column(OperatingSystem::cases(), "value");
        
        // map names to values
        return array_combine($names,$values);
    }

    public function loadFromFileMaker(): array
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/php/FMUtil.inc.php";
        $computers = [];
        $sql = "DELETE FROM `computers`";
        $this->db->query($sql);
        $sql = "ALTER TABLE `computers` AUTO_INCREMENT = 1";
        $this->db->query($sql);

        $fm = new FileMaker("Admin", "19MRCC77!", "IT Master Computer database", "IT Master Computer database");
        $records = $fm->getRecords(1, 1000);
        foreach ($records as $record) {

            $asset_number = intval($record["fieldData"]["Asset number"]);
            $make = $record["fieldData"]["Make"];
            $model = $record["fieldData"]["Model No."];

            $condition = Computer::parseCondition($record["fieldData"]["Condition"]);
            $device_type = Computer::parseDeviceType($record["fieldData"]["Device Type"]);
            $operating_system = Computer::parseOperatingSystem($record["fieldData"]["OS"]);

            $primary_user = $record["fieldData"]["Primary User"];
            $location = $record["fieldData"]["Location"];
            $notes = $record["fieldData"]["Notes"];
            
            // add all other fields to additional_information
            $additional_information = [];
            foreach (array_keys($record["fieldData"]) as $field) {
                if (!in_array($field, ["Asset number", "Make", "Model No.", "Condition", "Device Type", "OS", "Location", "Notes"])) {
                    $additional_information[$field] = $record["fieldData"][$field];
                }
            }
            
            $computer = new Computer($asset_number, $make, $model, $condition, $device_type, $operating_system, $primary_user, $location, json_encode($additional_information), $notes);

            $this->addComputer($computer);
            array_push($computers, $computer);
        }
        return $computers;
    }
}
