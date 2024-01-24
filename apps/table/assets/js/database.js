$("tbody").html(`<div class="loading"></div>`);

$(document).on("computersLoaded", (event, computers) => {
    for (const computer of computers) {
        let element = Computer.fromObject(computer).toDOM();
        $("tbody").append(element);
    }
    $("tbody .loading").remove();
});

const computers = new Computers();
