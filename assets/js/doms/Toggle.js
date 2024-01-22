export default class Toggle extends HTMLElement {
    constructor(name, value) {
        super();
        this.name = name;
        this.value = value;
        this.setAttribute("name", name);
        this.setAttribute("value", value);
        this.$ = $(this);
        this.$.html(name);
    }

    connectedCallback() {
        if (this.name != undefined) this.setAttribute("name", this.name);
        if (this.value != undefined) this.setAttribute("value", this.value);
        else this.value = this.getAttribute("value") == true;
        this.$.on("click", (e) => {
            this.value = !this.value;
            this.setAttribute("value", this.value);
            this.$.trigger("toggle", [{ value: this.value }]);
        });
    }

    setValue(value, trigger = true) {
        this.value = value;
        this.setAttribute("value", value);
        if (trigger) {
            this.$.trigger("toggle", [{ value: value }]);
        }
    }
}

customElements.define("toggle-field", Toggle);
