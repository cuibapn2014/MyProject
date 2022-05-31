/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./init-alpine');

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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    created() {
        dark = this.getThemeFromLocalStorage()
    },
    updated(){
        if (this.dark) {
            document.documentElement.classList.add('dark')
          } else {
            document.documentElement.classList.remove('dark')
          }
    },
    data() {
        return {
            isActive: 0,
            dark: false,
            isSideMenuOpen: false,
            isNotificationsMenuOpen: false,
            isProfileMenuOpen: false,
            isPagesMenuOpen: false,
            isModalOpen: false,
            trapCleanup: null,
        }
    },
    methods: {
        setActive(index) {
            this.isActive = index
            console.log(isActive)
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

        openModal() {
            this.isModalOpen = true
            this.trapCleanup = focusTrap(document.querySelector('#modal'))
        },
        closeModal() {
            this.isModalOpen = false
            this.trapCleanup()
        },
    }
});
