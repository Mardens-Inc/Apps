import DropdownOption from "./DropdownOption.js";

export default class Dropdown extends HTMLElement {
    /**
     * Creates a new Dropdown object.
     * @param {string} label The label of the dropdown.
     * @param {Array<DropdownOption>} options A list of DropdownOption objects.
     */
    constructor(label, options = []) {
        super();
        this.label = label;
        this.options = options;
        this.setAttribute("label", label);
        this.value = this.getAttribute("value");
        this.$ = $(this);
        if (this.$.find(".dropdown-items").length == 0) {
            const items = $("<div class='dropdown-items'></div>");
            items.append(this.options);
            this.$.append(items);
        }
    }

    connectedCallback() {
        this.setAttribute("tabindex", "-1");
        if (this.label == undefined && this.$.find(".name").length != 0) this.label = this.$.find(".name").html();
        if (this.label == undefined) this.label = this.getAttribute("label");
        if (this.label != undefined) this.$.prepend(`<span class="name">${this.label}</span>`);
        if (this.value != undefined) this.setAttribute("value", this.value);

        this.options = this.$.find("dropdown-option");

        if (this.$.find("dropdown-option[selected]").length != 0) {
            this.selectedOption = this.$.find("dropdown-option[selected]")[0];
            this.selectOption(this.selectedOption);
        }

        const valueLabel = this.$.find(".value");
        if (valueLabel.length == 0) {
            this.$.append($(`<span class="value">${this.selectedOption == undefined ? "" : this.selectedOption.label}</span>`));
        } else {
            this.$.find(".value").html(this.selectedOption == undefined ? "" : this.selectedOption.label);
        }

        this.$.find("dropdown-option").on("click", (e) => {
            this.selectOption(e.target);
            this.blur();
        });
    }
    /**
     * Adds an option to the dropdown.
     * @param {DropdownOption} option The option to add to the dropdown.
     */
    addOption(option) {
        this.options.push(option);
        this.appendChild(option);
    }

    /**
     * Removes an option from the dropdown.
     * @param {DropdownOption} option The option to remove from the dropdown.
     */
    removeOption(option) {
        this.options.splice(this.options.indexOf(option), 1);
        this.removeChild(option);
    }
    selectOption(option) {
        this.value = option.value;
        this.setAttribute("value", option.value);
        this.$.find("dropdown-option").attr("selected", null);
        option.select();
        const valueLabel = this.$.find(".value");
        if (valueLabel.length == 0) {
            this.$.append($(`<span class="value">${option.label}</span>`));
        } else {
            this.$.find(".value").html(option.label);
        }
        this.$.trigger("change", [{ value: option.value }]);
    }
    selectIndex(index) {
        this.selectOption(this.options[index]);
    }
}

customElements.define("drop-down", Dropdown);
