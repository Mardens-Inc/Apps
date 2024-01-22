import DomBuilder from "./dombuilder.js";
import Dropdown from "./doms/Dropdown.js";
import Toggle from "./doms/Toggle.js";
import DropdownOption from "./doms/DropdownOption.js";
let dropdown = new Dropdown("test", ["test1", "test2", "test3"]);
let option = new DropdownOption("test1", "0", true);
dropdown.addOption(option);
console.log(dropdown.outerHTML);

$(document).on("dropdowns-loaded", () => {
    $("dialog#add-item-modal dropdown#template").on("change", (_, data) => {
        buildAddAppOptionsFromTemplate(data.value);
    });

    /**
     *
     * @param {string} template The template to build the options from.
     */
    async function buildAddAppOptionsFromTemplate(template) {
        const json = await getTemplateJson(template);
        const templateOptions = $("dialog#add-item-modal #template-options");
        templateOptions.html("");
        templateOptions.append($(`<h2>${json["name"]}</h2>`));
        templateOptions.append($(`<p style="text-align: center; font-size: 1.5rem; margin-top: 10px; margin-bottom: 1rem;">${json["description"]}</p>`));

        for (const option of json["options"]) {
            console.log(option);
        }
    }

    async function getTemplateJson(template) {
        return await $.ajax({
            url: `/templates/${template}/template.json`,
            method: "GET",
            dataType: "json",
            beforeSend: () => {
                startLoading();
            },
            complete: () => {
                stopLoading();
            },
            success: (data) => {
                return data;
            },
            error: (xhr, status, error) => {
                console.log(error);
                alert(`Error: ${error}`);
                return null;
            },
        });
    }
});
