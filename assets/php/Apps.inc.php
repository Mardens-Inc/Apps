<?php

class App
{
    public string $id;
    public string $name;
    public string $description;
    public string $icon;
    public string $template;
    public bool $hidden;
    public string $additionalInformation;
    public datetime $created_at;
    public datetime $updated_at;

    function __construct(string $id, string $name, string $description, string $icon, string $template, bool $hidden, string $additionalInformation, datetime $created_at, datetime $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->icon = $icon;
        $this->template = $template;
        $this->hidden = $hidden;
        $this->additionalInformation = $additionalInformation;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromJSON(string $json): App
    {
        $obj = json_decode($json);
        if ($obj == null) {
            throw new Exception("Invalid JSON");
        }
        if ($obj->id == null) {
            $obj->id = "";
        }
        if ($obj->created_at == null) {
            $obj->created_at = date("Y-m-d H:i:s");
        }
        if ($obj->updated_at == null) {
            $obj->updated_at = date("Y-m-d H:i:s");
        }
        if($obj->hidden == null) {
            $obj->hidden = false;
        }
        if($obj->additionalInformation == null) {
            $obj->additionalInformation = "{}";
        }
        return new App($obj->id, $obj->name, $obj->description, $obj->icon, $obj->template, $obj->hidden, $obj->additionalInformation, $obj->created_at, $obj->updated_at);
    }
}

use Hashids\Hashids;

class Apps
{
    private $conn;
    private $hashIds;
    function __construct()
    {
        require_once "connections.inc.php";
        $this->conn = DB_Connect::connect();
        $this->hashIds = new Hashids($_ENV["HASH_SALT"], 10);

        // check if `apps` table exists, if not, create it
        $this->conn->query("CREATE TABLE IF NOT EXISTS `apps` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `description` varchar(255) NOT NULL,
            `icon` varchar(255) NOT NULL,
            `template` varchar(255) NOT NULL,
            `hidden` tinyint(1) NOT NULL DEFAULT '0',
            `additionalInformation` varchar(4096) NOT NULL,
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    function getApps(): array
    {
        $sql = "SELECT * FROM `apps`";
        $result = $this->conn->query($sql);
        $apps = [];
        while ($row = $result->fetch_assoc()) {
            $id = $this->hashIds->encode($row["id"]);
            $description = $row["description"];
            $name = $row["name"];
            $template = $row["template"];
            $icon = $row["icon"];
            $additionalInformation = $row["additionalInformation"];
            $hidden = $row["hidden"];
            $updated_at = $row["updated_at"];
            $created_at = $row["created_at"];
            $app = new App($id, $name, $description, $icon, $template, $hidden, $additionalInformation, $created_at, $updated_at);
            array_push($apps, $app);
        }
        return $apps;
    }
    function getApp(string $id): App
    {
        $id = $this->hashIds->decode($id);
        if (count($id) == 0) {
            throw new Exception("Invalid ID");
        }
        $id = $id[0];
        $sql = "SELECT * FROM `apps` WHERE `id` = $id";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $id = $this->hashIds->encode($row["id"]);
        $name = $row["name"];
        $description = $row["description"];
        $icon = $row["icon"];
        $template = $row["template"];
        $hidden = $row["hidden"];
        $additionalInformation = $row["additionalInformation"];
        $created_at = $row["created_at"];
        $updated_at = $row["updated_at"];
        return new App($id, $name, $description, $icon, $template, $hidden, $additionalInformation, $created_at, $updated_at);
    }

    function addApp(App $app): App
    {
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare("INSERT INTO `apps` (`name`, `description`, `icon`, `template`, `hidden`, `additionalInformation`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $app->name, $app->description, $app->icon, $app->template, $app->hidden, $app->additionalInformation);
        $stmt->execute();

        // Get the inserted id and return the added app.
        $id = $this->conn->insert_id;
        return $this->getApp($this->hashIds->encode($id));
    }

    function updateApp(string $id, App $app): App
    {
        $id = $this->hashIds->decode($id);
        if (count($id) == 0) {
            throw new Exception("Invalid ID");
        }
        $id = $id[0];
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare("UPDATE `apps` SET `name` = ?, `description` = ?, `icon` = ?, `template` = ?, `hidden` = ?, `additionalInformation` = ? WHERE `id` = ?");
        $stmt->bind_param("ssssisi", $app->name, $app->description, $app->icon, $app->template, $app->hidden, $app->additionalInformation, $id);
        $stmt->execute();

        // Get the inserted id and return the added app.
        return $this->getApp($this->hashIds->encode($id));
    }
}
