import Dropdown from "./doms/Dropdown.js";
import Toggle from "./doms/Toggle.js";
import DropdownOption from "./doms/DropdownOption.js";
import ArrayInput from "./doms/ArrayItem.js";
import FileInput from "./doms/FileInput.js";

$("dialog#add-item-modal drop-down#template").on("change", (_, data) => {
    buildAddAppOptionsFromTemplate(data.value);
});

$("dialog#add-item-modal drop-down#template dropdown-option")[0].click();
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
        switch (option.type) {
            case "select":
                const options = option.options.map((o) => new DropdownOption(o.name, o.value, o.value == option.default));
                const dropdown = new Dropdown(option.name, options);
                dropdown.title = option.description;
                templateOptions.append(dropdown);
                break;
            case "boolean":
                const toggle = new Toggle(option.name, option.default);
                toggle.title = option.description;
                templateOptions.append(toggle);
                break;
            case "text":
                const floatingLabel = $(`<div class="floating-input col"></div>`);
                const label = $(`<label for="${option.name}">${option.name}</label>`);
                const text = $(`<input type="text" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text.title = option.description;
                floatingLabel.append(text);
                floatingLabel.append(label);
                templateOptions.append(floatingLabel);
                break;
            case "number":
                const floatingLabel2 = $(`<div class="floating-input col"></div>`);
                const label2 = $(`<label for="${option.name}">${option.name}</label>`);
                const text2 = $(`<input type="number" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text2.title = option.description;
                floatingLabel2.append(text2);
                floatingLabel2.append(label2);
                templateOptions.append(floatingLabel2);
                break;
            case "color":
                const floatingLabel3 = $(`<div class="color-input center vertical row"></div>`);
                const label3 = $(`<label for="${option.name}" class='fill'>${option.name}</label>`);
                const text3 = $(`<input type="color" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                floatingLabel3.attr("title", option.description);
                floatingLabel3.append(label3);
                floatingLabel3.append(text3);
                templateOptions.append(floatingLabel3);
                break;
            case "date":
                const floatingLabel4 = $(`<div class="floating-input col"></div>`);
                const label4 = $(`<label for="${option.name}">${option.name}</label>`);
                const text4 = $(`<input type="date" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text4.title = option.description;
                floatingLabel4.append(text4);
                floatingLabel4.append(label4);
                templateOptions.append(floatingLabel4);
                break;
            case "time":
                const floatingLabel5 = $(`<div class="floating-input col"></div>`);
                const label5 = $(`<label for="${option.name}">${option.name}</label>`);
                const text5 = $(`<input type="time" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text5.title = option.description;
                floatingLabel5.append(text5);
                floatingLabel5.append(label5);
                templateOptions.append(floatingLabel5);
                break;
            case "datetime":
                const floatingLabel6 = $(`<div class="floating-input col"></div>`);
                const label6 = $(`<label for="${option.name}">${option.name}</label>`);
                const text6 = $(`<input type="datetime-local" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text6.title = option.description;
                floatingLabel6.append(text6);
                floatingLabel6.append(label6);
                templateOptions.append(floatingLabel6);
                break;
            case "textarea":
                const floatingLabel7 = $(`<div class="floating-input col"></div>`);
                const label7 = $(`<label for="${option.name}">${option.name}</label>`);
                const text7 = $(`<textarea type="text" placeholder="${option.description}" name="${option.name}">${option.default}</textarea>`);
                text7.title = option.description;
                floatingLabel7.append(text7);
                floatingLabel7.append(label7);
                templateOptions.append(floatingLabel7);
                break;

            case "file":
                const fileInput = $(`<file-input name="${option.name}" description="${option.description}" extensions="${option.extensions.join(",")}" multiple="${option.multiple}" default="${option.default}"></file-input>`);
                templateOptions.append(fileInput);
                break;
            case "array":
                const arrayInput = $(`<array-input name="${option.name}" description="${option.description}" default="${option.default.join(",")}"></array-input>`);
                templateOptions.append(arrayInput);
            default:
                break;
        }
    }

    templateOptions.append($("<div class='row center vertical fill'><button id='add-item' type='submit' style='margin: auto;width: 200px;'>Add</button></div>"));
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
