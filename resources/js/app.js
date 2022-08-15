/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import axios from 'axios';
import { mixin as clickaway } from 'vue-clickaway'
import Echo from 'laravel-echo';
import VueDragscroll from 'vue-dragscroll'
import VTooltip from 'v-tooltip'
import { dragscroll } from 'vue-dragscroll'
import { chartLine } from './charts-lines'
import { pieChart } from './charts-pie'
import { barChart } from './charts-bars'
import mediumZoom from "medium-zoom";




window.Vue = require('vue').default;
Vue.use(VueDragscroll)
Vue.use(VTooltip)

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
Vue.component('edit-order', require('./components/EditOrderComponent.vue').default);
Vue.component('profile', require('./components/ProfileComponent.vue').default);
Vue.component('task', require('./components/TaskComponent.vue').default);
Vue.component('modal-detail', require('./components/ModalDetail.vue').default);
Vue.component('plan-detail', require('./components/PlanDetail.vue').default);
Vue.component('plan-detail-edit', require('./components/PlanDetailEdit.vue').default);



window.axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
window.axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    mixins: [clickaway],
    directives: {
        'dragscroll': dragscroll
    },
    props: [
        'user'
    ],
    delimiters: [
        "[[", "]]"
    ],
    created() {
        this.user = document.querySelector('#app').getAttribute('user')
        this.fetchTask()
    },
    mounted() {
        this.getTheme()
        setTimeout(() => {
            this.isLoad = false
        }, 500)
        this.fetchRevenue()
        this.fetchDebt()
        this.fetchCountProductType()
        this.isActive = sessionStorage.getItem('selected_menu') && parseInt(sessionStorage.getItem('selected_menu'))
        if (this.isSaleActive())
            this.toggleSaleMenu()
        if (this.isWarehouseActive())
            this.toggleWarehouseMenu()
        if (this.isProductionActive())
            this.toggleProductionsMenu()
        // this.isActive > 0 && this.isActive < 2 && this.toggleSaleMenu()
        mediumZoom(document.querySelectorAll(".img__mthumbnail"), {
            background: "rgba(0,0,0,0.5)",
        });
    },
    updated() {
        this.getTheme()
    },
    data() {
        return {
            idDelete: 0,
            countTask: 0,
            display: 0,
            isLoad: true,
            isActive: 0,
            isOpenView: false,
            detailOrder: null,
            dark: this.getThemeFromLocalStorage(),
            isSideMenuOpen: false,
            isNotificationsMenuOpen: false,
            isProfileMenuOpen: false,
            isSalesMenuOpen: false,
            isProductionMenuOpen: false,
            isWarehouseMenuOpen: false,
            isModalOpen: false,
            isModalProfile: false,
            trapCleanup: null,
            checkAll: false,
            dataTask: []
        }
    },
    methods: {
        setIsActive(index) {
            this.isActive = index
        },
        async fetchRevenue() {
            await axios.get('/revenue/get')
                .then(res => chartLine(res.data))
                .catch(err => console.log(err))
        },
        async fetchDebt() {
            await axios.get('/debt/get')
                .then(res => barChart(res.data))
                .catch(err => console.log(err))
        },
        async fetchCountProductType() {
            await axios.get('/product-type/count')
                .then(res => pieChart(res.data))
                .catch(err => console.log(err))
        },
        async fetchTask() {
            this.getListTask()

            await axios.get('/admin/task/get')
                .then(res => {
                    this.dataTask = res.data
                    this.dataTask.map(item => {
                        this.countTask = item.TrangThai == 0 ? this.countTask + 1 : this.countTask
                    })
                })
                .catch(err => console.error(err))

            if (this.countTask > 0) {
                const oldTitle = document.title
                setInterval(() => {
                    document.title = document.title === oldTitle ? `Bạn có ${this.countTask} thông báo mới` : oldTitle
                }, 1000)
            }
        },

        getListTask() {
            window.Echo.private(`task.${this.user}`)
                .listen('TaskEvent', (e) => {
                    console.log(e)
                    this.dataTask.push(e.assign)
                    console.log(this.dataTask)
                    this.countTask += 1
                })
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

        setSelectedMenu(index) {
            sessionStorage.setItem('selected_menu', index)
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

        isWarehouseActive() {
            const arr = [2, 3, 5];
            return arr.includes(this.isActive)
        },

        isSaleActive() {
            const arr = [1, 6];
            return arr.includes(this.isActive)
        },

        isProductionActive() {
            const arr = [11, 12, 13];
            return arr.includes(this.isActive)
        },

        closeProfileMenu() {
            this.isProfileMenuOpen = false
        },

        toggleSaleMenu() {
            this.isSalesMenuOpen = !this.isSalesMenuOpen
        },

        toggleWarehouseMenu() {
            this.isWarehouseMenuOpen = !this.isWarehouseMenuOpen
        },

        toggleProductionsMenu() {
            this.isProductionMenuOpen = !this.isProductionMenuOpen
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

        getTheme() {
            if (this.dark) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        },
        handleClick() {
            this.display >= 0 && this.display <= 2 ? this.display++ : this.display
        },
        handleDeleteIngredient(id) {
            location.href = `/admin/ingredient/delete/${id}`
        },
        handleDeleteFabric(id) {
            location.href = `/admin/fabric/delete/${id}`
        },
        handleDeleteOrder(id) {
            location.href = `/admin/order/delete/${id}`
        },
        handleDeleteTask(id) {
            location.href = `/admin/task/delete/${id}`
        },
        handleDelete(url) {
            location.href = url + this.idDelete
        },
        handlePrintClick() {
            window.print()
        },
        toggleProfileModal(e) {
            this.isModalProfile = e.isOpenModal
        },
        openProfileModal() {
            this.isModalProfile = true
        },
        toggleCheckAll() {
            this.checkAll = !this.checkAll
        },
        handleClickBackDrop(e) {
            if (e.target == document.querySelector('#backdrop-overlay'))
                this.closeModal()
            else if (e.target == document.querySelector('#backdrop-menu-overlay'))
                this.closeSideMenu()
        },
        handleClickViewOrder(el) {
            this.detailOrder = el
            this.isOpenView = true
        },
        closeModalView(e) {
            this.isOpenView = e.isOpen
        }
    }
});
