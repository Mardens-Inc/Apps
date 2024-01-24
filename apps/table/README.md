# ITComputers API Documentation

This API provides access to the `computers` table in the database. It supports operations to get a specific computer, get the count of computers, search for computers, and filter computers.

# Table of Contents
- [ITComputers API Documentation](#itcomputers-api-documentation)
  - [Postman](#postman)
    - [Import](#import)
  - [GET Requests](#get-requests)
    - [GET a Specific Computer](#get-a-specific-computer)
    - [GET Enums](#get-enums)
    - [GET Unique](#retrieve-unique-data)
    - [Get Computer Count](#get-computer-count)
    - [Search Computers](#search-computers)
    - [Filter Computers](#filter-computers)
  - [Create a New Computer](#create-a-new-computer)
  - [Update a Computer](#update-a-computer)
  - [Delete a Computer](#delete-a-computer)

# Postman
Download the postman collection [here](https://raw.githubusercontent.com/Mardens-Inc/IT-Computers-Database/main/postman-collection.json) or copy it here:
```
https://raw.githubusercontent.com/Mardens-Inc/IT-Computers-Database/main/postman-collection.json
```
## Import
click the import button in postman.   
![image](https://github.com/Mardens-Inc/IT-Computers-Database/assets/5598099/24393246-2e1d-4238-8613-c6a98212853b)   
download the link or copy it and paste it here.   
![image](https://github.com/Mardens-Inc/IT-Computers-Database/assets/5598099/220984b4-b9b8-459c-8901-4b9c9599ce51)   




# GET Requests

This API provides several GET endpoints to retrieve data from the `computers` table in the database.

## GET a Specific Computer

To get a specific computer, make a GET request to the API with the `id` parameter.

Sure, here's a brief API documentation for the GET method in the provided PHP code:

---

## GET Enums

This endpoint is used to retrieve data from the ITComputers database.

### Parameters

- `mirror`: Mirrors the data from FileMaker. If successful, it returns a 200 status code with a message "Mirror successful!". If it fails, it returns a 500 status code with a message "Failed to mirror!".

- `enum`: Enumerates the data based on the provided value. The possible values are:
  - `all`: Returns all the operating systems, device types, and conditions.
  - `conditions`: Returns all the conditions.
  - `device_types`: Returns all the device types.
  - `operating_systems`: Returns all the operating systems.
  If an invalid value is provided, it returns a 400 status code with a message "Invalid enum".

- `id`: Retrieves a specific computer based on the provided ID. If successful, it returns the computer data. If it fails, it returns a 404 status code with a message "Failed to get computer" and the error message.

### Responses

- `200 OK`: The request was successful. The response body will contain the requested data.
- `400 Bad Request`: The request was invalid. The response body will contain an error message.
- `404 Not Found`: The requested computer was not found. The response body will contain an error message.
- `500 Internal Server Error`: The server encountered an error. The response body will contain an error message.

### Example

Request:

```
GET /db.php?enum=all
```

Response:

```json
{
    "operating_systems": {
        "Windows": 0,
        "MacOS": 1,
        /* ...etc */
    },
    "device_types": {
        "Desktop": 0,
        "Laptop": 1,
        /* ...etc */
    },
    "conditions": {
        "New": 0,
        "Good": 1,
        /* ...etc */
    }
}
```

Sure, here's the API documentation for the `unique` endpoint:

## Retrieve Unique Data

This endpoint retrieves unique data from the ITComputers database. The `unique` parameter specifies the type of unique data to retrieve.

### Retrieve All Unique Data

To retrieve all unique data, make a GET request to the API with the `unique` parameter set to `all`.

Example:

```bash
GET /db.php?unique=all
```

This will return a JSON object with unique `locations` and `make` values.

### Retrieve Unique Locations

To retrieve unique locations, make a GET request to the API with the `unique` parameter set to `locations`.

Example:

```bash
GET /db.php?unique=locations
```

This will return a JSON object with unique `locations` values.

### Retrieve Unique Make

To retrieve unique make values, make a GET request to the API with the `unique` parameter set to `make`.

Example:

```bash
GET /db.php?unique=make
```

This will return a JSON object with unique `make` values.

If the `unique` parameter is set to a value other than `all`, `locations`, or `make`, the API will return a 400 error with the message "Invalid unique".


## Get Computer Count

To get the count of computers, make a GET request to the API with the `count` parameter.

```
GET /db.php?count
```

This will return a JSON object with the count of computers.

## Search Computers

To search for computers, make a GET request to the API with the `search` parameter. You can also provide `limit`, `offset`, and `ascending` parameters to limit the number of results and sort them.

```
GET /db.php?search=Dell&limit=10&offset=0&ascending=true
```

This will return a JSON object with an array of computers that match the search term and the count of computers in the array. If no computers are found, it will return a 404 status code and a JSON object with a "No computers found" message.

## Filter Computers

To filter computers, make a GET request to the API with the `filter` parameter. The `filter` parameter should be a JSON-encoded array of filters. You can also provide `limit`, `offset`, and `ascending` parameters to limit the number of results and sort them.

```
GET /db.php?filter=[{"column":"make","value":"Dell"},{"column":"condition","value":1}]&limit=10&offset=0&ascending=true
```

This will return a JSON object with an array of computers that match the filters and the count of computers in the array. If no computers are found, it will return a 404 status code and a JSON object with a "No computers found" message.
# Create a New Computer

To create a new computer, make a POST request to the API with the following parameters in the body:

- `asset_number`: The asset number of the computer.
- `make`: The make of the computer.
- `model`: The model of the computer.
- `condition`: The condition of the computer.
- `device_type`: The type of the device.
- `primary_user`: The primary user of the computer.
- `location`: The location of the computer.
- `additional_information`: Additional information about the computer.
- `notes`: Notes about the computer.

Here's an example of how to make the request with curl:

```bash
curl -X POST -H "Content-Type: application/json" -d '{
    "asset_number": "12345",
    "make": "Dell",
    "model": "XPS 15",
    "condition": "New",
    "device_type": "Laptop",
    "primary_user": "John Doe",
    "location": "Office",
    "additional_information": "16GB RAM, 512GB SSD",
    "notes": "For software development"
}' /db.php
```

This will return a JSON object with the id of the new computer. If there was an error creating the computer, it will return a 500 status code and a JSON object with an "Error creating computer" message.

# Update a Computer

To update a computer, make a PUT request to the API with the `id` parameter in the URL and the following parameters in the body:

- `asset_number`: The asset number of the computer.
- `make`: The make of the computer.
- `model`: The model of the computer.
- `condition`: The condition of the computer.
- `device_type`: The type of the device.
- `primary_user`: The primary user of the computer.
- `location`: The location of the computer.
- `additional_information`: Additional information about the computer.
- `notes`: Notes about the computer.

Here's an example of how to make the request with curl:

```bash
curl -X PUT -H "Content-Type: application/json" -d '{
    "asset_number": "12345",
    "make": "Dell",
    "model": "XPS 15",
    "condition": "Used",
    "device_type": "Laptop",
    "primary_user": "John Doe",
    "location": "Home",
    "additional_information": "16GB RAM, 512GB SSD",
    "notes": "For software development"
}' /db.php?id=1
```

This will return a JSON object with the id of the updated computer. If there was an error updating the computer, it will return a 500 status code and a JSON object with an "Error updating computer" message.


# Delete a Computer

To delete a computer, make a DELETE request to the API with the `id` parameter in the URL.

Here's an example of how to make the request with curl:

```bash
curl -X DELETE /db.php?id=1
```

This will return a JSON object with a message indicating the computer was deleted. If there was an error deleting the computer, it will return a 500 status code and a JSON object with an "Error deleting computer" message.
