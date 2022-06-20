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
                <a @click="setIsActive(0)"
                    class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
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
                    <span class="ml-4">Quản lý đơn hàng</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <span v-if="this.isActive == 2"
                    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a @click="setIsActive(2)"
                    class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('admin.fabric.index') }}"
                    :class="{ 'text-gray-800' : this.isActive == 2, 'dark:text-gray-100' : this.isActive == 2 }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="ml-4">Quản lý loại vải</span>
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
                    <span class="ml-4">Quản lý phụ liệu</span>
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
    <h2 class="w-full h-auto text-sm px-3 dark:text-gray-200">{{\Carbon\Carbon::parse(now())->format('Y')}} © Copyright
        by LyunHouse</h2>
    <h2 class="w-full h-auto text-sm px-3 dark:text-gray-200">Developed by A&T</h2>
</aside>
<!-- Mobile sidebar -->
<!-- Backdrop -->
<transition enter-class="opacity-0" enter-to-class="opacity-100" leave-class="opacity-100" leave-to="opacity-0">
    <div v-show="isSideMenuOpen"
        class="fixed inset-0 z-10 flex duration-150 transition ease-in-out items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        @click="handleClickBackDrop" id="backdrop-menu-overlay">
    </div>
</transition>
<transition enter-class="opacity-0 transform -translate-x-20" enter-to="opacity-100"
    leave-class="opacity-100" leave-to-class="opacity-0 transform -translate-x-20">
    <aside class="fixed inset-y-0 z-20 transition ease-in-out duration-150 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-[#ffffff] dark:bg-gray-800 md:hidden"
        v-show="isSideMenuOpen" @keydown.escape="closeSideMenu">
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
                        <span class="ml-4">Quản lý đơn hàng</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <span v-if="this.isActive == 2"
                        class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a @click="setIsActive(2)"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        href="{{ route('admin.fabric.index') }}"
                        :class="{ 'text-gray-800' : this.isActive == 2, 'dark:text-gray-100' : this.isActive == 2 }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="ml-4">Quản lý loại vải</span>
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
                        <span class="ml-4">Quản lý phụ liệu</span>
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
            Copyright
            by LyunHouse</h2>
        <h2 class="w-full h-auto text-sm px-3 dark:text-gray-200">Developed by A&T</h2>
    </aside>
</transition>