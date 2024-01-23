import Dropdown from "./doms/Dropdown.js";
import Toggle from "./doms/Toggle.js";
import DropdownOption from "./doms/DropdownOption.js";
import ArrayInput from "./doms/ArrayItem.js";
import FileInput from "./doms/FileInput.js";

$("dialog#add-item-modal drop-down#template").on("change", (_, data) => {
    buildAddAppOptionsFromTemplate(data.value);
});

$("dialog#add-item-modal drop-down#template dropdown-option")[1].click();
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
        const id = option.name.toLowerCase().replace(/[^a-z]/g, "-");
        console.log(id);
        let element;

        switch (option.type) {
            case "select":
                const options = option.options.map((o) => new DropdownOption(o.name, o.value, o.value == option.default));
                const dropdown = new Dropdown(option.name, options);
                dropdown.title = option.description;
                templateOptions.append(dropdown);
                break;
            case "boolean":
                element = new Toggle(option.name, option.default);
                element.title = option.description;

                // check if any other options have a condition for this option
                const conditionals = json["options"].filter((o) => o.condition && o.condition == option.name);
                const update = (value) => {
                    if (value) {
                        conditionals.forEach((o) => {
                            const element = o.element;
                            if (element) {
                                element.css("display", "block");
                            }
                        });
                    } else {
                        conditionals.forEach((o) => {
                            const element = o.element;
                            if (element) {
                                element.css("display", "none");
                            }
                        });
                    }
                };
                $(element).on("toggle", (_, e) => {
                    update(e.value);
                });
                $(document).on("finish-building-options", () => {
                    update(element.value);
                });

                break;
            case "text":
                element = $(`<div class="floating-input col" id="${id}"></div>`);
                const label = $(`<label for="${option.name}">${option.name}</label>`);
                const text = $(`<input type="text" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text.title = option.description;
                element.append(text);
                element.append(label);
                break;
            case "number":
                element = $(`<div class="floating-input col"></div>`);
                const label2 = $(`<label for="${option.name}">${option.name}</label>`);
                const text2 = $(`<input type="number" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text2.title = option.description;
                element.append(text2);
                element.append(label2);
                break;
            case "color":
                element = $(`<div class="color-input center vertical row"></div>`);
                const label3 = $(`<label for="${option.name}" class='fill'>${option.name}</label>`);
                const text3 = $(`<input type="color" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                element.attr("title", option.description);
                element.append(label3);
                element.append(text3);
                break;
            case "date":
                element = $(`<div class="floating-input col"></div>`);
                const label4 = $(`<label for="${option.name}">${option.name}</label>`);
                const text4 = $(`<input type="date" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text4.title = option.description;
                element.append(text4);
                element.append(label4);
                break;
            case "time":
                element = $(`<div class="floating-input col"></div>`);
                const label5 = $(`<label for="${option.name}">${option.name}</label>`);
                const text5 = $(`<input type="time" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text5.title = option.description;
                element.append(text5);
                element.append(label5);
                break;
            case "datetime":
                element = $(`<div class="floating-input col"></div>`);
                const label6 = $(`<label for="${option.name}">${option.name}</label>`);
                const text6 = $(`<input type="datetime-local" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
                text6.title = option.description;
                element.append(text6);
                element.append(label6);
                break;
            case "textarea":
                element = $(`<div class="floating-input col"></div>`);
                const label7 = $(`<label for="${option.name}">${option.name}</label>`);
                const text7 = $(`<textarea type="text" placeholder="${option.description}" name="${option.name}">${option.default}</textarea>`);
                text7.title = option.description;
                element.append(text7);
                element.append(label7);
                break;

            case "file":
                element = $(`<file-input name="${option.name}" description="${option.description}" extensions="${option.extensions.join(",")}" multiple="${option.multiple}" default="${option.default}"></file-input>`);
                break;
            case "array":
                element = $(`<array-input name="${option.name}" description="${option.description}" default="${option.default.join(",")}"></array-input>`);
            default:
                break;
        }

        option.element = element;

        templateOptions.append(element);
    }

    templateOptions.append($("<div class='row center vertical fill' style='margin-top: 1rem;'><button id='add-item' type='submit' style='margin: auto;width: 200px;'>Add</button></div>"));

    $(document).trigger("finish-building-options");
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
