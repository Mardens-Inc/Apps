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
        this.value = null;
        this.$ = $(this);
    }


    connectedCallback() {
        this.label = this.getAttribute('label');
        this.options = this.children;
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
}

customElements.define('drop-down', Dropdown);