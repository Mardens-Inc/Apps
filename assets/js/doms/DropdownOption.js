export default class DropdownOption extends HTMLElement {
    constructor(label, value, selected = false) {
        super();
        this.$ = $(this);
        if (label != undefined) {
            this.label = label;
            this.$.append(`${label}`);
        }
        if (value != undefined) this.value = value;
        if (selected != undefined) {
            this.selected = selected;
            if (selected) {
                this.setAttribute("selected", "");
            }
        }
        if (value != undefined) this.setAttribute("value", value);
    }

    connectedCallback() {
        this.label = this.$.html();
        this.value = this.getAttribute("value");
        this.selected = this.getAttribute("selected") != undefined;
    }

    select() {
        this.selected = true;
        this.setAttribute("selected", "");
    }
    deselect() {
        this.selected = false;
        this.removeAttribute("selected");
    }
}

customElements.define("dropdown-option", DropdownOption);
