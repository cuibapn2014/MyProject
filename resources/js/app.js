/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('input-file', require('./components/InputFileComponent.vue').default);
Vue.component('image-modal', require('./components/ImageModalComponent.vue').default);
Vue.component('add-order', require('./components/AddOrderComponent.vue').default);

window.axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
window.axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    delimiters: [
        "[[", "]]"
    ],
    mounted(){
        this.getTheme()
    },
    updated(){
        this.getTheme()
    },
    data() {
        return {
            idDelete: 0,
            display: 0,
            isActive: 0,
            dark: this.getThemeFromLocalStorage(),
            isSideMenuOpen: false,
            isNotificationsMenuOpen: false,
            isProfileMenuOpen: false,
            isPagesMenuOpen: false,
            isModalOpen: false,
            trapCleanup: null
        }
    },
    methods: {
        setIsActive(index) {
            this.isActive = index
        },
        getThemeFromLocalStorage() {
            // if user already changed the theme, use it
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'))
            }

            // else return their preferences
            return (
                !!window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        },

        setThemeToLocalStorage(value) {
            window.localStorage.setItem('dark', value)
        },

        toggleTheme() {
            this.dark = !this.dark
            this.setThemeToLocalStorage(this.dark)
        },

        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen
        },
        closeSideMenu() {
            this.isSideMenuOpen = false
        },

        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
            this.closeProfileMenu()
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false
        },

        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen
            this.closeNotificationsMenu()
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false
        },

        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen
        },
        // Modal

        openModal(id) {
            this.idDelete = id
            this.isModalOpen = true
            // this.trapCleanup = focusTrap(document.querySelector('#modal'))
        },
        
        closeModal() {
            this.isModalOpen = false
            // this.trapCleanup()
        },

        getTheme(){
            if (this.dark) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        },
        handleClick(){
            this.display >= 0 && this.display <= 2 ? this.display++ : this.display
        },
        handleDeleteIngredient(id){
            location.href = `/admin/ingredient/delete/${id}`
        },
        handleDeleteFabric(id){
            location.href = `/admin/fabric/delete/${id}`
        }
    }
});
