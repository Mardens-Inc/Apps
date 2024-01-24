# ITComputers Class Documentation

The `ITComputers` class is used to interact with the `computers` table in the database. It provides methods to create the table if it doesn't exist and to retrieve a computer by its id.

## Constructor

The constructor for the `ITComputers` class is called when you create a new object of the class. It connects to the database and creates the `computers` table if it doesn't exist.

```php
$itComputers = new ITComputers();
```

## Methods

### getComputer(int $id): Computer

This method retrieves a computer from the database by its id.

```php
$computer = $itComputers->getComputer($id);
```
### filterComputers(array $filters, int $limit, int $offset, bool $ascending): array

This method retrieves computers from the database based on an array of filters. It also allows you to limit the number of results and sort them in ascending or descending order.

```php
$filters = [
    ["column" => "make", "value" => "Dell"],
    ["column" => "condition", "value" => 1]
];
$limit = 10;
$offset = 0;
$ascending = true;

$computers = $itComputers->filterComputers($filters, $limit, $offset, $ascending);
```
## Computer Class

The `Computer` class is used to represent a computer in the `computers` table. It has properties for each column in the table and a constructor to initialize them.

### Constructor

The constructor for the `Computer` class is called when you create a new object of the class. It initializes the properties of the object.

```php
$computer = new Computer($asset_number, $make, $model, $condition, $device_type, $primary_user, $location, $additional_information, $notes);
```

### Properties

- `asset_number`: The asset number of the computer.
- `make`: The make of the computer.
- `model`: The model of the computer.
- `condition`: The condition of the computer.
- `device_type`: The type of the device.
- `primary_user`: The primary user of the computer.
- `location`: The location of the computer.
- `additional_information`: Additional information about the computer.
- `notes`: Notes about the computer.
- `created_date`: The date the computer was created.
- `modified_date`: The date the computer was last modified.