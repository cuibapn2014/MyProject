@extends('layouts.layout_admin')
@section('title', 'Chỉnh sửa |Quản lý loại vải')
@section('main')
@php
$current = 2;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Quản lý loại vải - Chỉnh sửa
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    @if($errors->any())
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ $errors->first() }}</p>
    @endif
    <form action="{{route('admin.fabric.request.update',['id' => $fabric->id])}}" method="post">
        @csrf
        <div class="px-4 py-3 mb-8 bg-[#ffffff] rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tên loại vải</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="" value="{{$fabric->Ten}}" name="name" />
            </label>
            <label class="block text-sm my-2">
                <span class="text-gray-700 dark:text-gray-400">Màu sắc</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    value="{{$fabric->MauSac}}" name="color" />
            </label>
            <label class="block text-sm my-2">
                <span class="text-gray-700 dark:text-gray-400">Tính chất</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    value="{{$fabric->TinhChat}}" name="property" />
            </label>
            <label class="block text-sm my-2">
                <span class="text-gray-700 dark:text-gray-400">Giá</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    type="number" min="1" value="{{$fabric->Gia}}" name="price" />
            </label>
            <label class="block text-sm my-2">
                <span class="text-gray-700 dark:text-gray-400">Địa chỉ mua</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    type="text" value="{{$fabric->DiaChiMua}}" name="location" />
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Ghi chú</span>
                <textarea
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="3" placeholder="" name="note">{{$fabric->GhiChu}}</textarea>
            </label>
            <button class="mt-4 text-white px-4 py-2 rounded-lg border-0 bg-indigo-600">Lưu thay đổi</button>
            <a class="mt-4 text-white px-4 py-2 rounded-lg border-0 bg-indigo-600 cursor-pointer"
                @click="openModal">Quay về</a>
        </div>
    </form>
</div>

<div v-if="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
    <!-- Modal -->
    <div v-if="isModalOpen" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0  transform translate-y-1/2" v-click-outside="closeModal" @keydown.escape="closeModal"
        class="w-full px-6 py-4 overflow-hidden bg-[#ffffff] rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
        role="dialog" id="modal">
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
            <a href="{{url()->previous()}}"
                class="w-full px-5 py-3 text-center bg-purple-600 active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple text-white text-sm font-medium decoration-transparent leading-5 text-gray-700 transition-colors duration-150 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                Chắc chắn
            </a>
            <button @click="closeModal"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-[#000000] dark:text-gray-200 transition-colors duration-150 border dark:border-0 border-gray-200  rounded-lg sm:w-auto sm:px-4 sm:py-2 focus:outline-none">
                Hủy bỏ
            </button>
        </footer>
    </div>
</div>
</div>
@endsection