// resources/js/stores/modal.js
document.addEventListener('alpine:init', () => {
    Alpine.store('modal', {
        current: null,
        data: {},

        init() {
            this.handleModalEvents();
        },

        handleModalEvents() {
            window.addEventListener('open-modal', (event) => {
                if (typeof event.detail === 'object') {
                    this.current = event.detail.name;
                    this.data = event.detail;
                } else {
                    this.current = event.detail;
                    this.data = {};
                }
            });
        },

        close() {
            this.current = null;
            this.data = {};
        }
    });
});
