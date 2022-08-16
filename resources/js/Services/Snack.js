import { ref } from 'vue';

export default class Snack {
    constructor() {
        this.text = ref(null);
    }

    fireSnack(text, options = {}) {
        this.text.value = text;
        setTimeout(() => {
            this.text.value = null;
        }, 3000);
    }

    get message() {
        return this.text.value;
    }
}
