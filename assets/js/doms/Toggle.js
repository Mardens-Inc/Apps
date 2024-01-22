export default class Toggle extends HTMLElement {
    constructor() {
        super();
        this.value = false;
        this.$ = $(this);
    }

    connectedCallback() {
        this.value = this.getAttribute("value");
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