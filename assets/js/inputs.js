// Add a dragover event listener to all elements with the class "drag-drop-area".
// Prevent the default dragover behavior and add the "dragover" class to the target element.
$(".drag-drop-area").on("dragover", (e) => {
    let target = $(e.target);
    e.preventDefault();
    e.stopPropagation();
    target.addClass("dragover");
});

// Add a dragleave event listener to all elements with the class "drag-drop-area".
// Prevent the default dragleave behavior and remove the "dragover" class from the target element.
$(".drag-drop-area").on("dragleave", (e) => {
    let target = $(e.target);
    e.preventDefault();
    e.stopPropagation();
    target.removeClass("dragover");
});

// Add a drop event listener to all elements with the class "drag-drop-area".
// Prevent the default drop behavior, remove the "dragover" class from the target element, and handle the dropped file.
$(".drag-drop-area").on("drop", (e) => {
    let target = $(e.target);
    e.preventDefault();
    e.stopPropagation();
    target.removeClass("dragover");
    let file = e.originalEvent.dataTransfer.files[0];
    handleUploadedFile(file, target);
});

// Add a click event listener to all elements with the class "drag-drop-area".
// Create a new file input element, trigger a click event on it, and handle the selected file.
$(".drag-drop-area").on("click", (e) => {
    let target = $(e.currentTarget);
    let input = $(`<input type="file" accept="${target.attr("accept").replace(/\*/g, "")}">`);
    input.trigger("click");
    input.on("change", () => {
        let file = input.prop("files")[0];
        handleUploadedFile(file, target);
    });
});

// Define a function to handle uploaded files.
// Read the file as a data URL, remove the "dragover" class from the target element, and trigger an "upload" event with the file data.
function handleUploadedFile(file, target) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
        target.removeClass("dragover");
        let content = atob(reader.result.split(";base64,").pop());
        target.trigger("upload", [
            {
                name: file.name,
                content: content,
                file: file,
            },
        ]);
    };
}

// For each element with the class "drag-drop-area", set its HTML content to display the accepted file types.
$(".drag-drop-area").each((_, element) => {
    let target = $(element);
    let acceptAttr = target.attr("accept");
    target.html(`<i>(${acceptAttr})</i>`);
});

// Add a click event listener to all "toggle" elements.
// When a "toggle" element is clicked, prevent the default click behavior and toggle its value.
$("toggle").on("click", (e) => {
    // Prevent the default click behavior.
    e.preventDefault();
    // Get the target of the click event.
    let target = $(e.target);
    // Get the current value of the "value" attribute of the target.
    let value = target.attr("value") === "true";
    // Set the "value" attribute of the target to the opposite of its current value.
    target.attr("value", !value);
    // Trigger a "toggle" event on the target with the new value.
    target.trigger("toggle", [{ value: !value }]);
});

function startLoading() {
    $("body").append(`<div class="loading-body"><div class="loading"></div></div>`);
}

function stopLoading() {
    $("body .loading-body").remove();
}

$(document).ready(() => {
    $("select").each((_, element) => {
        let target = $(element);
        let options = target.find("option");
        let name = target.attr("name") == undefined ? "" : target.attr("name");
        let id = target.attr("id") == undefined ? "" : target.attr("id");
        let classes = target.attr("class") == undefined ? "" : target.attr("class");
        let selected = target.find("option[select]");

        let dropdown = $(`<dropdown id="${id}" class="${classes}" tabindex="-1"><div class="name">${name}</div><div class="value"></div></dropdown>`);
        let dropdownItems = $(`<dropdown-items></dropdown-items>`);
        dropdown.append(dropdownItems);
        dropdown.attr("value", selected.attr("value"));
        dropdown.find(".value").html(selected.html());

        options.each((_, option) => {
            let dropdownItem = $(`<dropdown-item value="${$(option).attr("value")}">${$(option).html()}</dropdown-item>`);

            dropdownItem.on("click", (e) => {
                let dropdownItem = $(e.target);
                let dropdown = dropdownItem.parent().parent();
                if (dropdownItem.hasClass("selected")) {
                    dropdownItem.removeClass("selected");
                    dropdown.attr("value", null);
                    dropdown.find(".value").html("");
                } else {
                    dropdown.find("dropdown-item.selected").removeClass("selected");
                    dropdownItem.addClass("selected");
                    dropdown.attr("value", dropdownItem.attr("value"));
                    dropdown.find(".value").html(dropdownItem.html());
                }
                dropdown.trigger("change", [{ value: dropdownItem.attr("value") }]);
                dropdown.blur();
            });

            dropdownItems.append(dropdownItem);

            if ($(option).attr("select") != undefined) {
                dropdownItem.addClass("selected");
                $(document).on("dropdowns-loaded", () => {
                    dropdown.trigger("change", [{ value: dropdownItem.attr("value") }]);
                });
            }
        });

        // replace target with dropdown
        target.replaceWith(dropdown);

        $(document).trigger("dropdowns-loaded");
    });
});