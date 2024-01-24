# ITComputers API

This API provides access to the `computers` table in the database. It supports operations to get a specific computer, get the count of computers, search for computers, and filter computers.

## End-point: Get Computers

This endpoint makes an HTTP GET request to retrieve data from the database via the specified URL. The request does not contain a request body.

The response returns an array of objects, each representing an entry from the database. Each object includes various properties such as id, asset_number, make, model, condition, device_type, operating_system, primary_user, location, additional_information, notes, created_date, and modified_date.

The additional_information property further includes details about the device's RAM and CPU. The created_date and modified_date properties include the date, time, and timezone information.

The response provides a comprehensive snapshot of the database entries, allowing users to retrieve detailed information about the assets.

### Method: GET

> ```
> /api/db.php
> ```

### Response: 200

```json
[
    {
        "id": 2,
        "asset_number": 123456,
        "make": "Dell",
        "model": "XPS 15",
        "condition": 0,
        "device_type": 0,
        "operating_system": 0,
        "primary_user": "0",
        "location": "Office",
        "additional_information": {
            "ram": "16GB",
            "cpu": "Intel i5"
        },
        "notes": "No issues",
        "created_date": {
            "date": "2024-01-15 11:10:11.000000",
            "timezone_type": 3,
            "timezone": "America/New_York"
        },
        "modified_date": {
            "date": "2024-01-15 14:21:56.082554",
            "timezone_type": 3,
            "timezone": "America/New_York"
        }
    }
]
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Get Unique

This endpoint makes an HTTP GET request to retrieve all unique data from the database. The request does not require any payload in the request body.

The response will contain an array of unique "locations" and an array of unique "make" values. The "locations" array may include various location names, while the "make" array will contain different make or brand names.

### Method: GET

> ```
> /api/db.php?unique=all
> ```

### Query Params

| Param  | value     |
| ------ | --------- |
| unique | all       |
| unique | locations |
| unique | make      |

### Response: 200

```json
{
    "locations": ["50 Ind", "50 Industrial", "Accounting", "Biddeford", "Brewer"],
    "make": ["HP", "Lenovo", "DELL", "GATEWAY", "ACER", "ASUS"]
}
```

### Response: 200

```json
{
    "locations": ["50 Ind", "50 Industrial", "Accounting", "Biddeford", "Brewer"]
}
```

### Response: 200

```json
{
    "make": ["HP", "Lenovo", "DELL", "GATEWAY", "ACER", "ASUS"]
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Get Enums

This endpoint makes an HTTP GET request to retrieve all the enums from the database. The request does not require any payload in the request body. The response will include the enumerated values for "operating_systems", "device_types", and "conditions". These values are used to categorize different types of operating systems, device types, and conditions. The response will provide the numerical representation of each enum value for reference in the application.

### Method: GET

> ```
> /api/db.php?enum=all
> ```

### Query Params

| Param | value             |
| ----- | ----------------- |
| enum  | all               |
| enum  | conditions        |
| enum  | device_types      |
| enum  | operating_systems |

### Response: 200

```json
{
    "operating_systems": {
        "Windows": 0,
        "MacOS": 1,
        "Linux": 2,
        "ChromeOS": 3,
        "Android": 4,
        "IOS": 5,
        "Umix": 6,
        "Other": 7
    },
    "device_types": {
        "Desktop": 0,
        "Laptop": 1,
        "Tablet": 2,
        "Phone": 3,
        "Server": 4,
        "Printer": 5,
        "Other": 6
    },
    "conditions": {
        "New": 0,
        "Good": 1,
        "Used": 2,
        "Refurbished": 3,
        "Broken": 4
    }
}
```

### Response: 200

```json
{
    "conditions": {
        "New": 0,
        "Good": 1,
        "Used": 2,
        "Refurbished": 3,
        "Broken": 4
    }
}
```

### Response: 200

```json
{
    "device_types": {
        "Desktop": 0,
        "Laptop": 1,
        "Tablet": 2,
        "Phone": 3,
        "Server": 4,
        "Printer": 5,
        "Other": 6
    }
}
```

### Response: 200

```json
{
    "operating_systems": {
        "Windows": 0,
        "MacOS": 1,
        "Linux": 2,
        "ChromeOS": 3,
        "Android": 4,
        "IOS": 5,
        "Umix": 6,
        "Other": 7
    }
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Load from FileMaker

This endpoint makes an HTTP GET request to retrieve data from the filemaker database at the specified URL. The request does not include a request body. Upon a successful call, the response will include a message indicating that the mirror operation was successful.

### Method: GET

> ```
> /api/db.php?mirror
> ```

### Query Params

| Param  | value |
| ------ | ----- |
| mirror | null  |

### Response: 200

```json
{
    "message": "Mirror successful!"
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Get Specific Computer

This endpoint makes an HTTP GET request to retrieve information about a specific item from the database. The request should include the 'id' parameter in the query string to specify the item to be retrieved.

The response contains details about the item, including its asset number, make, model, condition, device type, operating system, primary user, location, additional information (such as RAM and CPU), notes, and the dates when the item was created and last modified.

### Method: GET

> ```
> /api/db.php?id=1
> ```

### Query Params

| Param | value |
| ----- | ----- |
| id    | 1     |

### Response: 200

```json
{
    "id": 2,
    "asset_number": 123456,
    "make": "Dell",
    "model": "XPS 15",
    "condition": 0,
    "device_type": 0,
    "operating_system": 0,
    "primary_user": "0",
    "location": "Office",
    "additional_information": {
        "ram": "16GB",
        "cpu": "Intel i5"
    },
    "notes": "No issues",
    "created_date": {
        "date": "2024-01-15 11:10:11.000000",
        "timezone_type": 3,
        "timezone": "America/New_York"
    },
    "modified_date": {
        "date": "2024-01-15 14:23:52.704730",
        "timezone_type": 3,
        "timezone": "America/New_York"
    }
}
```

### Response: 404

```json
{
    "message": "Failed to get computer",
    "error": "No computer found with the provided id"
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Get Computer Count

This endpoint makes an HTTP GET request to retrieve the count from the specified database API. The request does not require any specific payload in the request body.

### Method: GET

> ```
> /api/db.php?count
> ```

### Query Params

| Param | value |
| ----- | ----- |
| count | null  |

### Response: 200

```json
{
    "count": 13
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Search Computers

# Get Computers by Search

This endpoint retrieves a list of computers based on the search criteria.

## Request

### Endpoint

`GET /api/db.php`

### Query Parameters

-   `search` (string, required): The search keyword to filter the computers.
-   `limit` (integer, optional): The maximum number of results to return. Default is 10.
-   `offset` (integer, optional): The offset for paginating through the results. Default is 0.
-   `ascending` (boolean, optional): Indicates whether the results should be sorted in ascending order. Default is true.

### Method: GET

> ```
> /api/db.php?search=Dell&limit=10&offset=0&ascending=true
> ```

### Query Params

| Param     | value |
| --------- | ----- |
| search    | Dell  |
| limit     | 10    |
| offset    | 0     |
| ascending | true  |

### Response: 200

```json
{
    "computers": [
        {
            "id": 1,
            "asset_number": 123456,
            "make": "Dell",
            "model": "XPS 15",
            "condition": 0,
            "device_type": 0,
            "operating_system": 0,
            "primary_user": "0",
            "location": "Office",
            "additional_information": {
                "ram": "16GB",
                "cpu": "Intel i5"
            },
            "notes": "No issues",
            "created_date": {
                "date": "2024-01-15 11:10:11.000000",
                "timezone_type": 3,
                "timezone": "America/New_York"
            },
            "modified_date": {
                "date": "2024-01-15 14:24:35.317580",
                "timezone_type": 3,
                "timezone": "America/New_York"
            }
        }
    ],
    "count": 1
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Add Computer

This API endpoint allows you to create a new entry in the database with information about an asset. The HTTP POST request should be sent to /api/db.php with a JSON payload in the raw request body.

### Request Body

-   `asset_number` (number): The unique asset number.
-   `make` (string): The make of the asset.
-   `model` (string): The model of the asset.
-   `condition` (number): The condition of the asset.
-   `device_type` (number): The type of the device.
-   `operating_system` (number): The operating system of the device.
-   `primary_user` (string): The primary user of the asset.
-   `location` (string): The location of the asset.
-   `additional_information` (object): Additional information about the asset, including `ram` (string) and `cpu` (string).
-   `notes` (string): Any additional notes about the asset.

### Method: POST

> ```
> /api/db.php
> ```

### Headers

| Content-Type | Value            |
| ------------ | ---------------- |
| Content-Type | application/json |

### Body (**raw**)

```json
{
    "asset_number": 123456,
    "make": "Dell",
    "model": "XPS 15",
    "condition": 0,
    "device_type": 0,
    "operating_system": 0,
    "primary_user": "John Doe",
    "location": "Office",
    "additional_information": {
        "ram": "18GB",
        "cpu": "Intel i5"
    },
    "notes": "No issues"
}
```

### Response: 201

```json
{
    "id": 14,
    "asset_number": 123456,
    "make": "Dell",
    "model": "XPS 15",
    "condition": 0,
    "device_type": 0,
    "operating_system": 0,
    "primary_user": "0",
    "location": "Office",
    "additional_information": {
        "ram": "18GB",
        "cpu": "Intel i5"
    },
    "notes": "No issues",
    "created_date": {
        "date": "2024-01-15 14:21:09.000000",
        "timezone_type": 3,
        "timezone": "America/New_York"
    },
    "modified_date": {
        "date": "2024-01-15 14:21:09.128006",
        "timezone_type": 3,
        "timezone": "America/New_York"
    }
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Update Computer

This endpoint allows you to update a record in the database using an HTTP PUT request. The request should be sent to /api/db.php with a payload in the raw request body type. The payload should include the following parameters:

-   id (number): The ID of the record to be updated.
-   asset_number (number): The asset number of the device.
-   make (string): The make of the device.
-   model (string): The model of the device.
-   condition (number): The condition of the device.
-   device_type (number): The type of the device.
-   operating_system (number): The operating system of the device.
-   primary_user (string): The primary user of the device.
-   location (string): The location of the device.
-   additional_information (object): Additional information about the device including:
    -   ram (string): The RAM of the device.
    -   cpu (string): The CPU of the device.
-   notes (string): Any additional notes related to the device.

### Method: PUT

> ```
> /api/db.php
> ```

### Headers

| Content-Type | Value            |
| ------------ | ---------------- |
| Content-Type | application/json |

### Body (**raw**)

```json
{
    "id": 1,
    "asset_number": 123456,
    "make": "Samsung",
    "model": "XPS 15",
    "condition": 0,
    "device_type": 0,
    "operating_system": 0,
    "primary_user": "John Doe",
    "location": "Office",
    "additional_information": {
        "ram": "18GB",
        "cpu": "Intel i5"
    },
    "notes": "No issues"
}
```

### Response: 200

```json
{
    "success": true
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Delete Computer

This endpoint sends an HTTP DELETE request to delete a computer from the database with the specified ID.

The request does not have a request body, and the ID of the computer to be deleted is provided as a query parameter in the URL.

### Method: DELETE

> ```
> /api/db.php?id=1
> ```

### Query Params

| Param | value |
| ----- | ----- |
| id    | 1     |

### Response: 200

```json
{
    "message": "Computer deleted successfully!"
}
```

⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃
