@extends('layouts.layout_admin')
@section('title', 'Chỉnh sửa | Xuất kho')
@section('main')
@php
$current = 14;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Xuất kho - Chỉnh sửa
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    @if($errors->any())
    <p class="p-2 max-w-fit rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ $errors->first() }}</p>
    @endif
    <form action="{{ route('admin.warehouse.export.update', ['id' => $export->id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <warehouse-export :product_update="{{ json_encode($export) }}" :orders="{{ json_encode($orders) }}"
            :products="{{ json_encode($products) }}" :productions="{{ json_encode($productions->load('product')) }}">
        </warehouse-export>
    </form>
</div>
<transition enter-class="ease-out opacity-0" enter-to-class="opacity-100" leave-class="ease-in opacity-100"
    leave-to-class="opacity-0">
    <div v-show="this.isModalOpen" class="
        fixed
        inset-0
        z-30
        flex
        items-end
        transition duration-150
        bg-black bg-opacity-50
        sm:items-center sm:justify-center
      " id="backdrop-overlay" @click="handleClickBackDrop">
        <transition enter-class="ease-out opacity-0 transform translate-y-1/2" enter-to-class="opacity-100"
            leave-class="ease-in opacity-100" leave-to-class="opacity-0 transform translate-y-1/2">
            <!-- Modal -->
            <div v-show="this.isModalOpen" class="
          w-full
          px-6
          py-4
          overflow-hidden
          bg-[#ffffff]
          rounded-t-lg
          duration-150
          dark:bg-gray-800
          sm:rounded-lg sm:m-4 sm:max-w-xl
        " role="dialog" id="modal">
                <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                <header class="flex justify-end">
                    <button
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                        aria-label="close" @click="closeModal">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                            <path
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                    </button>
                </header>
                <!-- Modal body -->
                <div class="mt-4 mb-6">
                    <!-- Modal title -->
                    <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Xác nhận hủy thay đổi
                    </p>
                    <!-- Modal description -->
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Mọi thứ chưa được lưu, bạn có chắc chắc muốn rời khỏi đây ?
                    </p>
                </div>
                <footer
                    class="flex flex-row items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                    <a href="{{ route('admin.production.index') }}"
                        class="w-full px-5 py-3 text-center bg-purple-600 active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple text-white text-sm font-medium decoration-transparent leading-5 text-gray-700 transition-colors duration-150 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                        Chắc chắn
                    </a>
                    <button @click="closeModal"
                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-[#000000] dark:text-gray-200 transition-colors duration-150 border dark:border-0 border-gray-200  rounded-lg sm:w-auto sm:px-4 sm:py-2 focus:outline-none">
                        Hủy bỏ
                    </button>
                </footer>
            </div>
        </transition>
    </div>
</transition>
@endsection