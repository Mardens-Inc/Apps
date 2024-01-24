export default class ArrayInput extends HTMLElement {
    /**
     * Creates a new ArrayInput.
     * @param {string} name The name of the input.
     * @param {string} description The description of the input.
     * @param {string[]} items The items to accept.
     */
    constructor(name, description, items) {
        super();
        this.option = {
            name: this.getAttribute("name") || name || "",
            description: this.getAttribute("description") || description || "",
            default: (this.getAttribute("default") ? this.getAttribute("default").split(",") : items) || [],
            items: [],
        };
        this.value = this.option.items;
        this.$ = $(this);
    }

    connectedCallback() {
        this.render();
    }

    addItem(item) {
        this.option.items.push(item);
        let itemElement = document.createElement("div");
        itemElement.className = "item";
        itemElement.textContent = item;
        itemElement.addEventListener("click", () => {
            this.removeItem(itemElement);
        });
        this.textInput.value = "";
        this.itemsContainer.appendChild(itemElement);
        this.setAttribute("value", this.option.items.join(","));
        this.value = this.option.items;
    }

    removeItem(item) {
        this.option.items.splice(this.option.items.indexOf(item), 1);
        this.setAttribute("value", this.option.items.join(","));
        item.remove();
        this.value = this.option.items;
    }

    render() {
        this.innerHTML = `
            <div class="floating-input array-input row">
                <div class='items row center vertical'></div>
                <input type="text" no-form placeholder="${this.option.description}" name="${this.option.name}" value="" class="fill">
                <label for="${this.option.name}">${this.option.name}</label>
                <div class="button"><i class="fa fa-add"></i></div>
            </div>
        `;

        this.button = this.querySelector(".button");

        this.button.addEventListener("click", () => {
            this.addItem(this.textInput.value);
        });

        this.itemsContainer = this.querySelector(".items");
        this.textInput = this.querySelector("input");
        this.textInput.addEventListener("keydown", (e) => {
            if (e.key == "Enter") {
                e.preventDefault();
                this.button.click();
            } else if (e.key == "Backspace" && this.textInput.value == "") {
                if(this.option.items.length == 0) return;
                let item = this.option.items.pop();
                this.textInput.value = item;
                this.setAttribute("value", this.option.items.join(","));
                this.itemsContainer.lastChild.remove();
            }
        });

        this.setAttribute("value", this.option.default.join(","));
        this.option.default.forEach((item) => {
            this.addItem(item);
        });
        this.value = this.option.items;
    }
    formAssociatedCallback(form) {
        return this.option.items;
    }
}

customElements.define("array-input", ArrayInput);
