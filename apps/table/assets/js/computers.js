class Condition {
    static New = 0;
    static Good = 1;
    static Used = 2;
    static Refurbished = 3;
    static Broken = 4;
}

class DeviceType {
    static Desktop = 0;
    static Laptop = 1;
    static Tablet = 2;
    static Phone = 3;
    static Server = 4;
    static Printer = 5;
    static Other = 6;
}

class OperatingSystem {
    static Windows = 0;
    static MacOS = 1;
    static Linux = 2;
    static ChromeOS = 3;
    static Android = 4;
    static iOS = 5;
    static Umix = 6;
    static Other = 7;
}

class UniqueFields {
    static All = "all";
    static Make = "make";
    static Location = "locations";
}

class Enums {
    static All = "all";
    static Condition = "condition";
    static DeviceType = "device_types";
    static OperatingSystem = "operating_systems";
}

class Computer {
    /**
     * Creates a new computer
     * @param {Number} asset_number The asset number of the computer
     * @param {String} make The make of the computer
     * @param {String} model The model of the computer
     * @param {Condition} condition The condition of the computer
     * @param {DeviceType} device_type The type of device
     * @param {OperatingSystem} operating_system The operating system of the computer
     * @param {String} primary_user The primary user of the computer
     * @param {String} location The location of the computer
     * @param {String} additional_information Additional information about the computer
     * @param {String} notes Notes about the computer
     * @returns {Computer} The computer
     */
    constructor(asset_number, make, model, condition, device_type, operating_system, primary_user, location, additional_information, notes) {
        this.id = 0;
        this.asset_number = asset_number;
        this.make = make;
        this.model = model;
        this.condition = condition;
        this.device_type = device_type;
        this.operating_system = operating_system;
        this.primary_user = primary_user;
        this.location = location;
        this.additional_information = additional_information;
        this.notes = notes;
        this.created_date = new Date();
        this.modified_date = new Date();
    }

    /**
     * Creates a new computer from JSON
     * @param {JSON} json The JSON to create the computer from
     * @returns {Computer|false} The computer or false if it couldn't be created
     */
    static fromJSON(json) {
        try {
            const data = JSON.parse(json);
            const computer = new Computer(data.asset_number, data.make, data.model, data.condition, data.device_type, data.operating_system, data.primary_user, data.location, data.additional_information, data.notes);
            computer.id = data.id;
            computer.created_date = new Date(data.created_date);
            computer.modified_date = new Date(data.modified_date);
            return computer;
        } catch (error) {
            return false;
        }
    }

    static fromObject(object) {
        return object && Object.assign(new Computer(), object);
    }

    toDOM() {
        return $(`
        <tr>
            <td class="asset_number">${this.asset_number}</td>
            <td class="make">${this.make}</td>
            <td class="model">${this.model}</td>
            <td class="condition">${Computer.getConditionFromNumber(this.condition)}</td>
            <td class="device_type">${Computer.getDeviceTypeFromNumber(this.device_type)}</td>
            <td class="operating_system">${Computer.getOperatingSystemFromNumber(this.operating_system)}</td>
            <td class="primary_user">${this.primary_user}</td>
            <td class="location">${this.location}</td>
            <td class="additional_information">${this.additional_information}</td>
            <td class="notes">${this.notes}</td>
            </tr>
            `);
    }

    static getConditionFromNumber(number) {
        let conditionsMap = computers.enums.conditions;
        for (const condition in conditionsMap) {
            if (conditionsMap[condition] == number) {
                return condition;
            }
        }
    }
    static getOperatingSystemFromNumber(number) {
        let operatingSystemsMap = computers.enums.operating_systems;
        for (const operatingSystem in operatingSystemsMap) {
            if (operatingSystemsMap[operatingSystem] == number) {
                return operatingSystem;
            }
        }
    }
    static getDeviceTypeFromNumber(number) {
        let deviceTypesMap = computers.enums.device_types;
        for (const deviceType in deviceTypesMap) {
            if (deviceTypesMap[deviceType] == number) {
                return deviceType;
            }
        }
    }
}

class Computers {
    computers = [];
    constructor() {
        this.baseUrl = `${window.location.pathname}api/db.php`;
        
        this.makes = [];
        this.locations = [];
        this.computers = [];
        this.enums = {};
        this.getUnique().then((data) => {
            this.makes = data.makes;
            this.locations = data.locations;
        });
        this.getEnums()
            .then((data) => {
                this.enums = data;
            })
            .then(() => {
                this.getComputers().then((data) => {
                    this.computers = data;
                    $(document).trigger("computersLoaded", [this.computers]);
                });
            });
    }

    /**
     * Gets a list of computers from the database
     * @returns {Array<Computer>} An array of computers
     */
    async getComputers() {
        return await $.ajax({
            url: this.baseUrl,
            method: "GET",
            dataType: "json",
            success: (data) => {
                const computers = [];
                for (const computer of data) {
                    computers.push(Computer.fromJSON(computer));
                }
                return computers;
            },
        });
    }

    /**
     * Gets a computer from the database
     * @param {Number} id The id of the computer to get
     * @returns {Computer|false} The computer or false if it doesn't exist
     */
    async getComputer(id) {
        return await $.ajax({
            url: `${this.baseUrl}?id=${id}`,
            method: "GET",
            dataType: "json",
            success: (data) => Computer.fromJSON(data),
            error: () => false,
        });
    }

    /**
     * Gets the number of computers in the database
     * @returns {Number} The number of computers in the database
     */
    async getComputerCount() {
        return await $.ajax({
            url: `${this.baseUrl}?count=true`,
            method: "GET",
            dataType: "json",
            success: (data) => data.count,
        });
    }

    /**
     * Gets a list of computers from the database
     * @param {Number} limit The maximum number of computers to get
     * @param {Number} offset The offset to start at
     * @param {Boolean} ascending True if the computers should be sorted ascending, false otherwise
     * @returns {Array<Computer>} An array of computers
     */
    async searchComputers(search, limit = 10, offset = 0, ascending = true) {
        return await $.ajax({
            url: `${this.baseUrl}?search=${search}&limit=${limit}&offset=${offset}&ascending=${ascending}`,
            method: "GET",
            dataType: "json",
            success: (data) => {
                const computers = [];
                for (const computer of data.computers) {
                    computers.push(Computer.fromJSON(computer));
                }
                return computers;
            },
        });
    }

    /**
     * Gets a list of computers from the database
     * @param {Number} limit The maximum number of computers to get
     * @param {Number} offset The offset to start at
     * @param {Boolean} ascending True if the computers should be sorted ascending, false otherwise
     * @returns {Array<Computer>} An array of computers
     */
    async filterComputers(filter, limit = 10, offset = 0) {
        return await $.ajax({
            url: `${this.baseUrl}?filter=${JSON.stringify(filter)}&limit=${limit}&offset=${offset}`,
            method: "GET",
            dataType: "json",
            success: (data) => {
                const computers = [];
                for (const computer of data.computers) {
                    computers.push(Computer.fromJSON(computer));
                }
                return computers;
            },
        });
    }

    /**
     * Adds a computer to the database
     * @param {Computer} computer The computer to add
     * @returns {JSON} The response from the server
     */
    async addComputer(computer) {
        return await $.ajax({
            url: this.baseUrl,
            method: "POST",
            data: JSON.stringify(computer),
            contentType: "application/json",
            dataType: "json",
            success: (data) => Computer.fromJSON(data),
        });
    }

    /**
     * Updates a computer in the database
     * @param {Number} id The id of the computer to update
     * @param {Computer} computer The computer to update
     * @returns {JSON} The response from the server
     */
    async updateComputer(id, computer) {
        return await $.ajax({
            url: `${this.baseUrl}?id=${id}`,
            method: "PUT",
            data: JSON.stringify(computer),
            contentType: "application/json",
            dataType: "json",
            success: (data) => Computer.fromJSON(data),
        });
    }

    /**
     *  Deletes a computer from the database
     * @param {Number} id The id of the computer to delete
     * @returns {Boolean} True if the computer was deleted, false otherwise
     */
    async deleteComputer(id) {
        return await $.ajax({
            url: `${this.baseUrl}?id=${id}`,
            method: "DELETE",
            dataType: "json",
            success: () => true,
            error: () => false,
        });
    }

    /**
     * Get a list of unique values from the database
     * @param {UniqueFields} field The field to get unique values from
     * @returns {JSON} The response from the server
     */
    async getUnique(field = UniqueFields.All) {
        return await $.ajax({
            url: `${this.baseUrl}?unique=${field}`,
            method: "GET",
            dataType: "json",
            success: (data) => data,
        });
    }

    /**
     * Get a list of unique values from the database
     * @param {Enums} field The field to get unique values from
     * @returns {JSON} The response from the server
     */
    async getEnums(field = Enums.All) {
        return await $.ajax({
            url: `${this.baseUrl}?enum=${field}`,
            method: "GET",
            dataType: "json",
            success: (data) => data,
        });
    }
}
