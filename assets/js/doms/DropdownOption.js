export default class DropdownOption extends HTMLElement {
    constructor(label, value, selected = false) {
        super();
        this.label = label;
        this.value = value;
        this.selected = selected;
        this.$ = $(this);
        this.setAttribute("value", value);
        if (selected) {
            this.setAttribute("selected", "");
        }
        this.$.append(`<label>${label}</label>`)
    }

    connectedCallback() {
        this.label = this.$.find("label").html();
        this.value = this.getAttribute("value");
        this.selected = this.getAttribute("selected");
    }

    select() {
        this.selected = true;
        this.classList.add("selected");
    }
}

customElements.define("dropdown-option", DropdownOption);
