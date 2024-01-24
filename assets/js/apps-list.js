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
    const templateOptions = $("#template-options");
    templateOptions.empty();

    templateOptions.append(`<h2>${json["name"]}</h2>`);
    templateOptions.append(`<p style="text-align: center; font-size: 1.5rem; margin-top: 10px; margin-bottom: 1rem;">${json["description"]}</p>`);

    $("dialog#add-item-modal form").on('submit', async (e) => {
        let formData = new FormData(e.target);
        console.log(formData);

    });

    async function handlePopulatedUrl(url, match, element) {
        const name = match[1];
        const e = $(`dialog#add-item-modal #template-options [label="${name}"]`);
        e.on("change", async () => {
            const value = e.val();
            const newUrl = url.replace(match[0], encodeURIComponent(value));

            const options = await fetchData(newUrl);
            element.options = options.map((o) => new DropdownOption(o, o, false));
            element.rerender();
        });
    }

    async function fetchData(url) {
        try {
            startLoading();
            const options = await $.ajax({
                url,
                method: "GET",
                dataType: "json",
            });
            return options;
        } catch (error) {
            console.log(error);
            alert(`Error: ${error}`);
            return null;
        } finally {
            stopLoading();
        }
    }

    for (const option of json["options"]) {
        const id = option.name.toLowerCase().replace(/[^a-z]/g, "-");
        let element;

        switch (option.type) {
            case "select":
                if (option["populated_from_url"]) {
                    element = new Dropdown(option.name, []);
                    element.title = option.description;
                    const url = option["populated_from_url"];
                    if (url.includes("{")) {
                        const regex = /{([^}]+)}/g;
                        const matches = [...url.matchAll(regex)];
                        for (const match of matches) {
                            await handlePopulatedUrl(url, match, element);
                        }

                        break;
                    }

                    const options = await fetchData(url);
                    element = new Dropdown(option.name, options.map((o) => new DropdownOption(o, o, false)));
                    element.title = option.description;
                    break;
                }

                const options = option.options.map((o) => new DropdownOption(o.name, o.value, o.value == option.default));
                element = new Dropdown(option.name, options);
                element.title = option.description;
                break;

            case "boolean":
                element = new Toggle(option.name, option.default);
                element.title = option.description;

                const conditionals = json["options"].filter((o) => o.condition && o.condition == option.name);
                const update = (value) => {
                    conditionals.forEach((o) => {
                        const element = o.element;
                        if (element) {
                            $(element).css("display", value ? "block" : "none");
                        }
                    });
                };

                $(element).on("toggle", (_, e) => {
                    update(e.value);
                });

                $(document).on("finish-building-options", () => {
                    update(element.value);
                });
                break;

            case "text":
                element = buildInputElement("text", option);
                break;

            case "number":
                element = buildInputElement("number", option);
                break;

            case "color":
                element = buildColorInputElement(option);
                break;

            case "date":
            case "time":
            case "datetime":
                element = buildInputElement(option.type, option);
                break;

            case "textarea":
                element = buildTextareaElement(option);
                break;

            case "file":
                element = $(`<file-input name="${option.name}" description="${option.description}" extensions="${option.extensions.join(",")}" multiple="${option.multiple}" default="${option.default}"></file-input>`);
                break;

            case "array":
                element = $(`<array-input name="${option.name}" description="${option.description}" default="${option.default.join(",")}"></array-input>`);
                break;

            default:
                break;
        }

        option.element = element;
        $(element).attr("id", id);
        templateOptions.append(element);
    }

    templateOptions.append("<div class='row center vertical fill' style='margin-top: 1rem;'><button id='add-item' type='submit' style='margin: auto;width: 200px;'>Add</button></div>");

    $(document).trigger("finish-building-options");
}

function buildInputElement(type, option) {
    const id = option.name.toLowerCase().replace(/[^a-z]/g, "-");
    const element = $(`<div class="floating-input col" id="${id}"></div>`);
    const label = $(`<label for="${option.name}">${option.name}</label>`);
    const input = $(`<input type="${type}" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
    input.title = option.description;
    element.append(input);
    element.append(label);
    return element;
}

function buildColorInputElement(option) {
    const element = $(`<div class="color-input center vertical row"></div>`);
    const label = $(`<label for="${option.name}" class='fill'>${option.name}</label>`);
    const input = $(`<input type="color" placeholder="${option.description}" name="${option.name}" value="${option.default}">`);
    element.attr("title", option.description);
    element.append(label);
    element.append(input);
    return element;
}

function buildTextareaElement(option) {
    const id = option.name.toLowerCase().replace(/[^a-z]/g, "-");
    const element = $(`<div class="floating-input col"></div>`);
    const label = $(`<label for="${option.name}">${option.name}</label>`);
    const textarea = $(`<textarea type="text" placeholder="${option.description}" name="${option.name}">${option.default}</textarea>`);
    textarea.title = option.description;
    element.append(textarea);
    element.append(label);
    return element;
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
