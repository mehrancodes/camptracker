var base = require('navbar/navbar');
var dropdown = require('./dropdown');

Vue.component('main-navbar', {
    components: { dropdown },
    mixins: [base],
    data: () => ({
        navbarOpen: false,
        dropDownOpen: false
    }),
    mounted() {
        this.closeDropDown()
    },
    methods: {
        toggleIt() {
            this.navbarOpen = !this.navbarOpen;
        },
        toggleDropDown() {
            this.dropDownOpen = !this.dropDownOpen
        },
        closeDropDown() {
            document.addEventListener('click', e => {
                if (!this.$el.contains(e.target)) {
                    this.dropDownOpen = false
                }
            });

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    this.dropDownOpen = false
                }
            })
        }
    }
});
