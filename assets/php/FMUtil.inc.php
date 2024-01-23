<?php

/**
 * A class for interacting with the FileMaker Data API.
 * @author Drew Chase <drew.chase@mardens.com>
 * @version 0.0.1
 */
class FileMaker
{
    private $database;
    private $token;
    private $table;

    /**
     * Creates a new FileMaker object.
     * @param string $username The username for the FileMaker Data API.
     * @param string $password The password for the FileMaker Data API.
     * @param string $database The database name.
     * @param string $table The table name.
     * @return FileMaker The new FileMaker object.
     * @example $fm = new FileMaker('user', 'pass123', 'db_name', 'Inventory');
     */
    public function __construct($username, $password, $database, $table)
    {
        // Encode the username and password as a base64 string this is used to get the session token
        // Set the database name
        $this->database = $database;
        // Set the table name
        $this->table = $table;

        //url encode table and database
        $this->database = str_replace(" ", "%20", $this->database);
        $this->table = str_replace(" ", "%20", $this->table);

        // Get the session token
        $this->token = FileMaker::getSessionToken($database, base64_encode($username . ":" . $password));
    }

    /**
     * Gets a session token from the FileMaker Data API.
     * @return string The session token.
     */
    public static function getSessionToken(string $database, string $base64)
    {
        // Define the URL for the FileMaker Data API endpoint
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/" . $database . "/sessions";

        $options = array(
            'http' => array(
                // Set the HTTP method to POST
                'method' => 'POST',
                // Define the HTTP headers for the request
                'header' => "Authorization: Basic " . $base64 . "\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to an empty JSON object
                'content' => "{}",
                // Ignore HTTP errors and continue to get the content
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        );
        // Create a stream context for the HTTP request
        $context = stream_context_create($options);

        // Send the HTTP request and get the response content
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred
        if ($result === FALSE) {
            // Output an error message
            echo 'Error: Unable to get content';
            // End the function
            return "";
        }

        // Decode the JSON response into an associative array
        $resultArray = json_decode($result, true);

        // Return the token
        return $resultArray['response']['token'];
    }

    public static function getDatabaseNames(string $username, string $password): array
    {
        // Define the URL for the FileMaker Data API endpoint, including the database name and layout name.
        // The _offset and _limit query parameters are used for pagination.
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/";

        // Create a stream context for the HTTP request.
        $context = stream_context_create(array(
            'http' => array(
                // Set the HTTP method to GET.
                'method' => 'GET',
                // Define the HTTP headers for the request, including the authorization token.
                'header' => "Authorization: Basic " . base64_encode($username . ":" . $password) . "\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to an empty JSON object.
                'content' => "{}",
                // Ignore HTTP errors and continue to get the content.
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification.
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        // Send the HTTP request and get the response content.
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred.
        if ($result === FALSE) {
            // Output an error message.
            echo 'Error: Unable to get content';
            // Return an empty array.
            return [];
        }


        // Decode the JSON response into an associative array.
        $resultArray = json_decode($result, true)['response']['databases'];

        // map the array to only return the database names
        $resultArray = array_map(function ($item) {
            return $item['name'];
        }, $resultArray);

        // Return the 'data' array from the response.
        return  $resultArray;
    }

    public static function getDatabaseLayouts(string $username, string $password, string $database)
    {
        // Define the URL for the FileMaker Data API endpoint, including the database name and layout name.
        // The _offset and _limit query parameters are used for pagination.
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/";
        $token = FileMaker::getSessionToken($database, base64_encode($username . ":" . $password));
        // Create a stream context for the HTTP request.
        $context = stream_context_create(array(
            'http' => array(
                // Set the HTTP method to GET.
                'method' => 'GET',
                // Define the HTTP headers for the request, including the authorization token.
                'header' => "Authorization: Bearer " . $token . "\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to an empty JSON object.
                'content' => "{}",
                // Ignore HTTP errors and continue to get the content.
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification.
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        // Send the HTTP request and get the response content.
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred.
        if ($result === FALSE) {
            // Output an error message.
            echo 'Error: Unable to get content';
            // Return an empty array.
            return [];
        }

        die($result);

        // Decode the JSON response into an associative array.
        $resultArray = json_decode($result, true);

        die(json_encode($resultArray));

        // Return the 'data' array from the response.
        return  $resultArray['response']['layouts'];
    }



    /**
     * Gets the records from the database.
     * @param int $start The starting record number. (This value is 1-based.)
     * @param int $limit The number of records to get.
     * @return array The records.
     */
    public function getRecords($start = 1, $limit = 10)
    {
        // Define the URL for the FileMaker Data API endpoint, including the database name and layout name.
        // The _offset and _limit query parameters are used for pagination.
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/" . $this->database . "/layouts/$this->table/records?_offset=" . $start . "&_limit=" . $limit;

        // Create a stream context for the HTTP request.
        $context = stream_context_create(array(
            'http' => array(
                // Set the HTTP method to GET.
                'method' => 'GET',
                // Define the HTTP headers for the request, including the authorization token.
                'header' => "Authorization: Bearer " . $this->token . "\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to an empty JSON object.
                'content' => "{}",
                // Ignore HTTP errors and continue to get the content.
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification.
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        // Send the HTTP request and get the response content.
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred.
        if ($result === FALSE) {
            // Output an error message.
            echo 'Error: Unable to get content';
            // Return an empty array.
            return [];
        }

        // Decode the JSON response into an associative array.
        $resultArray = json_decode($result, true);

        // Return the 'data' array from the response.
        return  $resultArray['response']['data'];
    }

    /**
     * Gets the field names for the specified record.
     * @param array $record A record example.
     * @return array The field names.
     */
    public function getRowNamesByExample($record)
    {
        // Return the 'data' array from the response.
        return array_keys($record['fieldData']);
    }

    /**
     * Gets the field names for the first record.
     */
    public function getRowNames()
    {
        return $this->getRowNamesByExample($this->getRecords()[0]);
    }

    /**
     * Searches the database for records matching the specified query.
     * @param array $fields The query.
     * @param array $sort The sort order.
     * @param bool $ascending Whether to sort in ascending order.
     * @return array The matching records.
     */
    public function Search($fields, $sort = [], $ascending = true)
    {
        // Define the URL for the FileMaker Data API endpoint, including the database name and layout name.
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/" . $this->database . "/layouts/$this->table/_find";

        // Set the HTTP body content to a JSON object containing the query and sort parameters.
        $content = [];
        $content["query"] = [$fields];
        foreach ($sort as $sort) {
            $content["sort"] += ["fieldName" => $sort, "sortOrder" => $ascending ? "ascend" : "descend"];
        }

        // Create a stream context for the HTTP request.
        $context = stream_context_create(array(
            'http' => array(
                // Set the HTTP method to POST.
                'method' => 'POST',
                // Define the HTTP headers for the request, including the authorization token.
                'header' => "Authorization: Bearer " . $this->token . "\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to a JSON object containing the query and sort parameters.
                'content' => json_encode($content),
                // Ignore HTTP errors and continue to get the content.
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification.
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        // Send the HTTP request and get the response content.
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred.
        if ($result === FALSE) {
            // Output an error message.
            echo 'Error: Unable to get content';
            // Return an empty array.
            return [];
        }

        // Decode the JSON response into an associative array.
        $resultArray = json_decode($result, true);

        $result = $resultArray['response']['data'];
        if ($result == null) return [];
        // Return the 'data' array from the response.
        return  $result;
    }
    /**
     * Updates a record in the database.
     * @param int $id The ID of the record to update.
     * @param array $fieldData The field data to update.
     * @return array The updated record.
     */
    public function updateRecord($id, $fieldData)
    {
        // Define the URL for the FileMaker Data API endpoint, including the database name, layout name, and record ID.
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/" . $this->database . "/layouts/$this->table/records/$id";
        // Create a stream context for the HTTP request.
        $context = stream_context_create(array(
            'http' => array(
                // Set the HTTP method to PATCH.
                'method' => 'PATCH',
                // Define the HTTP headers for the request, including the authorization token.
                'header' => "Authorization: Bearer $this->token\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to a JSON object containing the field data to be updated.
                'content' => json_encode(["fieldData" => $fieldData]),
                // Ignore HTTP errors and continue to get the content.
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification.
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        // Send the HTTP request and get the response content.
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred.
        if ($result === FALSE) {
            // Output an error message.
            echo 'Error: Unable to get content';
            // Return an empty array.
            return [];
        }

        $record = $this->getRecordById($id);

        // Return the 'data' array from the response.
        return  ["result" => json_decode($result, true), "record" => $record];
    }

    /**
     * Adds a record to the database.
     * @param array $fieldData The field data for the new record.
     * @return array The added record.
     */
    public function addRecord($fieldData)
    {
        if (count($this->Search($fieldData)) > 0) {
            $record = $this->Search($fieldData)[0]["recordId"];
            return $this->updateRecord($record['recordId'], $fieldData);
        }
        // Define the URL for the FileMaker Data API endpoint, including the database name and layout name.
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/" . $this->database . "/layouts/$this->table/records/";

        // die(json_encode(["fieldData" => $fieldData]));

        // Create a stream context for the HTTP request.
        $context = stream_context_create(array(
            'http' => array(
                // Set the HTTP method to POST.
                'method' => 'POST',
                // Define the HTTP headers for the request, including the authorization token.
                'header' => "Authorization: Bearer " . $this->token . "\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to an empty string.
                'content' => json_encode(["fieldData" => $fieldData]),
                // Ignore HTTP errors and continue to get the content.
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification.
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        // Send the HTTP request and get the response content.
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred.
        if ($result === FALSE) {
            // Output an error message.
            echo 'Error: Unable to get content';
            // Return an empty array.
            return ["success" => false];
        }

        // Gets the inserted record
        $result = json_decode($result, true);
        $recordId = $result["response"]["recordId"];
        $result = $this->getRecordById($recordId);

        return ["success" => true, "result" => $result];
    }

    /**
     * Gets a record from the database.
     * @param int $id The ID of the record to get.
     * @return array The record.
     */
    public function getRecordByID($id)
    {
        // Define the URL for the FileMaker Data API endpoint, including the database name, layout name, and record ID.
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/" . $this->database . "/layouts/$this->table/records/$id";

        // Create a stream context for the HTTP request.
        $context = stream_context_create(array(
            'http' => array(
                // Set the HTTP method to GET.
                'method' => 'GET',
                // Define the HTTP headers for the request, including the authorization token.
                'header' => "Authorization: Bearer " . $this->token . "\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to an empty JSON object.
                'content' => "{}",
                // Ignore HTTP errors and continue to get the content.
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification.
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        // Send the HTTP request and get the response content.
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred.
        if ($result === FALSE) {
            // Output an error message.
            echo 'Error: Unable to get content';
            // Return an empty array.
            return [];
        }

        // Decode the JSON response into an associative array.
        $resultArray = json_decode($result, true);

        // Return the 'data' array from the response.
        return  $resultArray['response']['data'];
    }

    /**
     * Deletes a record from the database.
     * @param int $id The ID of the record to delete.
     * @return array The deleted record.
     */
    public function deleteRecord($id)
    {
        // Define the URL for the FileMaker Data API endpoint, including the database name, layout name, and record ID.
        $url = "https://fm.mardens.com/fmi/data/vLatest/databases/" . $this->database . "/layouts/$this->table/records/$id";

        // Create a stream context for the HTTP request.
        $context = stream_context_create(array(
            'http' => array(
                // Set the HTTP method to DELETE.
                'method' => 'DELETE',
                // Define the HTTP headers for the request, including the authorization token.
                'header' => "Authorization: Bearer " . $this->token . "\r\n" .
                    "User-Agent: PHP\r\n" .
                    "Content-Type: application/json\r\n",
                // Set the HTTP body content to an empty JSON object.
                'content' => "{}",
                // Ignore HTTP errors and continue to get the content.
                'ignore_errors' => true,
            ),
            'ssl' => array(
                // Disable SSL peer and host verification.
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        // Send the HTTP request and get the response content.
        $result = file_get_contents($url, false, $context);

        // If the result is FALSE, an error occurred.
        if ($result === FALSE) {
            // Output an error message.
            echo 'Error: Unable to get content';
            // Return an empty array.
            return [];
        }

        // Return the 'data' array from the response.
        return  ["success" => true];
    }

    /**
     * Deletes all records from the database.
     */
    public function clearDatabase()
    {
        $records = $this->getRecords();
        foreach ($records as $record) {
            $id = $record['recordId'];
            $this->deleteRecord($id);
        }
    }
}
