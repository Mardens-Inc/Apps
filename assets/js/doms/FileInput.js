export default class FileInput extends HTMLElement {
    /**
     * Creates a new FileInput.
     * @param {string} name The name of the input.
     * @param {string} description The description of the input.
     * @param {string[]} extensions The extensions to accept.
     * @param {boolean} multiple Whether to accept multiple files.
     */
    constructor(name = "", description = "", extensions = [], multiple = false) {
        super();
        this.option = {
            name: this.getAttribute("name") || name,
            description: this.getAttribute("description") || description,
            extensions: this.getAttribute("extensions").split(",") || extensions,
            multiple: this.getAttribute("multiple") || multiple,
        };
        this.value = "";
    }

    connectedCallback() {
        this.render();
    }

    handleFileInput(e) {
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = (readerEvent) => {
            var content = readerEvent.target.result;
            this.button.textContent = file.name;
            this.value = content;
        };
    }
    formAssociatedCallback(form) {
        return this.value;
    }

    render() {
        this.setAttribute("title", this.option.description);
        this.innerHTML = `
            <label for="${this.option.name}" class="fill">${this.option.name}</label>
            <div class="button">File</div>
        `;

        this.button = this.querySelector(".button");
        this.addEventListener("click", () => {
            let input = document.createElement("input");
            input.type = "file";
            input.accept = this.option.extensions.join(",");
            input.multiple = this.option.multiple;
            input.onchange = this.handleFileInput.bind(this);
            input.click();
        });
    }
}

customElements.define("file-input", FileInput);
