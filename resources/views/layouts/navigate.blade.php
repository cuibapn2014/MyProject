<aside class="z-20 hidden w-64 overflow-y-auto bg-[#ffffff] dark:bg-gray-800 md:block flex-shrink-0 relative">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ route('admin.home') }}">
            {{config('app.name')}}
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <span v-if="isActive == 0"
                    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.home') }}"
                    :class="{ 'text-gray-800' : this.isActive == 0, 'dark:text-gray-100' : this.isActive == 0 }">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-4">Bảng điều khiển</span>
                </a>
            </li>
        </ul>
        <ul>
            <li class="relative px-6 py-3">
                <span v-if="this.isSaleActive()"
                    class="absolute inset-y-0 left-0 w-1 max-h-14 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    @click="toggleSaleMenu" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="ml-4"
                            :class="{ 'text-gray-800' : this.isSaleActive(), 'dark:text-gray-100' : this.isSaleActive() }">Quản
                            lý bán hàng</span>
                    </span>
                    <svg class="w-4 h-4 duration-150" :class="{'-rotate-90': !isSalesMenuOpen}" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <transition enter-class="opacity-25 max-h-0" enter-to-class="opacity-100 max-h-xl"
                    leave-class="opacity-100 max-h-xl" leave-to-class="opacity-0 max-h-0">
                    <template v-if="isSalesMenuOpen">
                        <ul class="transition-all ease-in-out duration-300 p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                            aria-label="submenu">
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 1, 'dark:text-gray-100' : this.isActive == 1 }"
                                    href="{{ route('admin.order.index') }}">
                                    Đơn hàng
                                </a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 6, 'dark:text-gray-100' : this.isActive == 6 }"
                                    href="{{ route('admin.customer.index') }}">
                                    Khách hàng
                                </a>
                            </li>
                        </ul>
                    </template>
                </transition>
            </li>
            <li class="relative px-6 py-3">
                <span v-if="this.isProductionActive()"
                    class="absolute inset-y-0 left-0 w-1 max-h-14 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    @click="toggleProductionsMenu" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                        </svg>
                        <span class="ml-4"
                            :class="{ 'text-gray-800' : this.isProductionActive(), 'dark:text-gray-100' : this.isProductionActive() }">Quản
                            lý sản xuất</span>
                    </span>
                    <svg class="w-4 h-4 duration-150" :class="{'-rotate-90': !isProductionMenuOpen}" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <transition enter-class="opacity-25 max-h-0" enter-to-class="opacity-100 max-h-xl"
                    leave-class="opacity-100 max-h-xl" leave-to-class="opacity-0 max-h-0">
                    <template v-if="isProductionMenuOpen">
                        <ul class="transition-all ease-in-out duration-300 p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                            aria-label="submenu">
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 11, 'dark:text-gray-100' : this.isActive == 11 }"
                                    href="{{ route('admin.production.index') }}">
                                    Đề nghị sản xuất
                                </a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 12, 'dark:text-gray-100' : this.isActive == 12 }"
                                    href="{{ route('admin.plan.index') }}">
                                    Lệnh sản xuất
                                </a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 13, 'dark:text-gray-100' : this.isActive == 13 }"
                                    href="{{ route('admin.requirement.index') }}">
                                    Đề xuất mua hàng
                                </a>
                            </li>
                        </ul>
                    </template>
                </transition>
            </li>
            <li class="relative px-6 py-3">
                <span v-if="this.isWarehouseActive()"
                    class="absolute inset-y-0 left-0 w-1 max-h-14 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <button
                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    @click="toggleWarehouseMenu" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="ml-4"
                            :class="{ 'text-gray-800' : this.isWarehouseActive(), 'dark:text-gray-100' : this.isWarehouseActive() }">
                            Kho</span>
                    </span>
                    <svg class="w-4 h-4 duration-150" :class="{'-rotate-90': !isWarehouseMenuOpen}" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <transition enter-class="opacity-25 max-h-0" enter-to-class="opacity-100 max-h-xl"
                    leave-class="opacity-100 max-h-xl" leave-to-class="opacity-0 max-h-0">
                    <template v-if="isWarehouseMenuOpen">
                        <ul class="transition-all ease-in-out duration-300 p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                            aria-label="submenu">
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 10, 'dark:text-gray-100' : this.isActive == 10 }"
                                    href="{{ route('admin.warehouse.import.index') }}">
                                    Nhập kho
                                </a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 14, 'dark:text-gray-100' : this.isActive == 14 }"
                                    href="{{ route('admin.warehouse.export.index') }}">
                                    Xuất kho
                                </a>
                            </li>
                            <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 3, 'dark:text-gray-100' : this.isActive == 3 }"
                                    href="{{ route('admin.ingredient.index') }}">
                                    Nguyên phụ liệu
                                </a>
                            </li>
                            <li
                            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 5, 'dark:text-gray-100' : this.isActive == 5 }"
                                    href="{{ route('admin.product.index') }}">
                                    Thành phẩm
                                </a>
                            </li>
                            <!-- <li
                                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                <a class="w-full hover:text-gray-800 dark:hover:text-gray-200"
                                    :class="{ 'text-gray-800' : this.isActive == 5, 'dark:text-gray-100' : this.isActive == 5 }"
                                    href="javascript:void(0)">
                                    Sản phẩm
                                </a>
                            </li> -->
                        </ul>
                    </template>
                </transition>
            </li>
            <li class="relative px-6 py-3">
                <span v-if="this.isActive == 4"
                    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.task.index') }}"
                    :class="{ 'text-gray-800' : this.isActive == 4, 'dark:text-gray-100' : this.isActive == 4 }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="ml-4"> Công việc</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <span v-if="this.isActive == 7"
                    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.provider.index') }}"
                    :class="{ 'text-gray-800' : this.isActive == 7, 'dark:text-gray-100' : this.isActive == 7 }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="ml-4"> Nhà cung cấp</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <span v-if="this.isActive == 8"
                    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.finance.index') }}"
                    :class="{ 'text-gray-800' : this.isActive == 8, 'dark:text-gray-100' : this.isActive == 8 }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-4"> Tài chính</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <span v-if="this.isActive == 9"
                    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.employee.index') }}"
                    :class="{ 'text-gray-800' : this.isActive == 9, 'dark:text-gray-100' : this.isActive == 9 }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="ml-4"> Nhân sự</span>
                </a>
            </li>
        </ul>
    </div>
    <h2 class="w-full h-auto text-sm px-3 dark:text-gray-200">{{\Carbon\Carbon::parse(now())->format('Y')}} ©
        All right Reserved</h2>
    <h2 class="w-full h-auto text-sm px-3 dark:text-gray-200">Developed by Manh Tuan</h2>
</aside>
<!-- Mobile sidebar -->
<!-- Backdrop -->
<transition enter-class="opacity-0" enter-to-class="opacity-100" leave-class="opacity-100" leave-to="opacity-0">
    <div v-show="isSideMenuOpen"
        class="fixed inset-0 z-10 flex duration-150 transition ease-in-out items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        @click="handleClickBackDrop" id="backdrop-menu-overlay">
    </div>
</transition>
<transition enter-class="opacity-0 transform -translate-x-20" enter-to="opacity-100" leave-class="opacity-100"
    leave-to-class="opacity-0 transform -translate-x-20">
    <aside
        class="fixed inset-y-0 z-[60] transition ease-in-out duration-150 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-[#ffffff] dark:bg-gray-800 md:hidden"
        :class="{'z-[60]' : isSideMenuOpen}" v-show="isSideMenuOpen" @keydown.escape="closeSideMenu">
        <div class="py-4 text-gray-500 dark:text-gray-400">
            <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                {{config('app.name')}}
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    <span v-if="isActive == 0"
                        class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a @click="setIsActive(0)"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.home') }}"
                        :class="{ 'text-gray-800' : this.isActive == 0, 'dark:text-gray-100' : this.isActive == 0 }">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="ml-4">Bảng điều khiển</span>
                    </a>
                </li>
            </ul>
            <ul>
                <li class="relative px-6 py-3">
                    <span v-if="this.isActive == 1"
                        class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a @click="setIsActive(1)"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.order.index') }}"
                        :class="{ 'text-gray-800' : this.isActive == 1, 'dark:text-gray-100' : this.isActive == 1 }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="ml-4">Đơn hàng</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span v-if="this.isActive == 2"
                        class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a @click="setIsActive(2)"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href=""
                        :class="{ 'text-gray-800' : this.isActive == 2, 'dark:text-gray-100' : this.isActive == 2 }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="ml-4">Vải</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span v-if="this.isActive == 3"
                        class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a @click="setIsActive(3)"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.ingredient.index') }}"
                        :class="{ 'text-gray-800' : this.isActive == 3, 'dark:text-gray-100' : this.isActive == 3 }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="ml-4">Nguyên phụ liệu</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span v-if="this.isActive == 4"
                        class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a @click="setIsActive(4)"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.task.index') }}"
                        :class="{ 'text-gray-800' : this.isActive == 4, 'dark:text-gray-100' : this.isActive == 4 }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                        <span class="ml-4"> Công việc</span>
                    </a>
                </li>
            </ul>
        </div>
        <h2 class="w-full h-auto text-sm px-3 dark:text-gray-200">{{\Carbon\Carbon::parse(now())->format('Y')}} ©
            All right Reserved</h2>
        <h2 class="w-full h-auto text-sm px-3 dark:text-gray-200">Developed by Manh Tuan</h2>
    </aside>
</transition>