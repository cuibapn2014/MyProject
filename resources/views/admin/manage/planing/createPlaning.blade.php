@extends('layouts.layout_admin')
@section('title', 'Thêm mới |Kế hoạch sản xuất')
@section('main')
@php
$current = 12;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Kế hoạch sản xuất - Thêm mới
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    <form action="{{ route('admin.plan.request.create') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center mb-2 flex-wrap">
            <img src="{{ asset('/img_product/') . '/' . $production_request->image }}"
                class="w-36 rounded-lg object-fit mr-2 my-2 img__mthumbnail" alt="">

            <label class="block text-sm my-2 grow">
                <span class="text-gray-700 dark:text-gray-400">Đề nghị sản xuất <span
                        class="text-red-500">*</span></span>
                <select class=" block
            w-full
            mt-1
            h-10
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
            mb-1" name="id_production_request" id="id_production_request" aria-placeholder="Chọn đề nghị sản xuất">
                    <option value="" disabled selected>-- Chọn đề nghị sản xuất --</option>
                    <option value="{{ $production_request->id }}" selected>
                        {{ $production_request->code . __(' - ') . $production_request->name }}
                    </option>
                </select>
                @error('id_production_request')
                <span class="text-red-500 pt-2">{{ $message }}</span>
                @enderror
            </label>
            <label class="block text-sm mx-2 grow my-2">
                <span class="text-gray-700 dark:text-gray-400">Mã kế hoạch <span class="text-red-500">*</span></span>
                <input
                    class="block w-full mt-1 h-10 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Nhập mã kế hoạch" name="code"
                    value="{{ old('code') ?? __('PPC') . rand(100000, 999999) }}" />
                @error('code')
                <span class="text-red-500 pt-2">{{ $message }}</span>
                @enderror
            </label>
            <label class="block text-sm my-2 mr-2">
                <span class="text-gray-700 dark:text-gray-400">Công đoạn <span class="text-red-500">*</span></span>
                <select class=" block
            w-full
            mt-1
            h-10
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
            mb-1" name="stage" id="stage" aria-placeholder="Chọn công đoạn">
                    <option value="0" selected>Cắt</option>
                    <option value="1">Bán thành phẩm</option>
                    <option value="2">Hoàn thiện</option>
                </select>
            </label>
            <label class="block text-sm my-2">
                <span class="text-gray-700 dark:text-gray-400">Mức độ ưu tiên <span class="text-red-500">*</span></span>
                <select class=" block
            w-full
            mt-1
            h-10
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
            mb-1" name="priority" id="priority" aria-placeholder="Chọn mức độ ưu tiên">
                    <option value="0" selected>Thấp</option>
                    <option value="1">Trung bình</option>
                    <option value="2">Cao</option>
                </select>
            </label>
        </div>
        <div class="flex items-center">
            <label class="block text-sm grow">
                <span class="text-gray-700 dark:text-gray-400">Tên sản phẩm <span
                        class="text-red-500">*</span></span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Nhập tên sản phẩm (vd: Tay áo, cổ áo,...)" name="name_product"
                    value="{{ old('name_product') }}" />
                @error('name_product')
                <span class="text-red-500 pt-2">{{ $message }}</span>
                @enderror
            </label>
            <label class="block text-sm my-2 mx-2">
                <span class="text-gray-700 dark:text-gray-400">Số lượng/Sản phẩm <span class="text-red-500">*</span></span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    type="number" placeholder="Nhập số lượng" min="1" value="{{ old('quota') ?? 1 }}" name="quota" />
                @error('quota')
                <span class="text-red-500 pt-2">{{ $message }}</span>
                @enderror
            </label>   
        </div>
        <plan-detail :ingredients="{{ $ingredient }}"></plan-detail>
        @error('id_ingredient.0')
        <span class="text-red-500 pt-2 mt-2">{{ $message }}</span>
        @enderror
        <label class="block mt-3 text-sm">
            <span class="text-gray-700 dark:text-gray-400">Ghi chú</span>
            <textarea
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                rows="3" placeholder="Nhập ghi chú" name="note">{{ old('note') }}</textarea>
        </label>
        <div class="flex justify-start">
            <button class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 mx-2">Lưu</button>
            <button type="button" class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-yellow-400 cursor-pointer"
                @click="openModal">Quay về</button>
        </div>
    </form>
</div>
<transition enter-class="ease-out opacity-0" enter-to-class="opacity-100" leave-class="ease-in opacity-100"
    leave-to-class="opacity-0">
    <div v-show="this.isModalOpen" class="
        fixed
        inset-0
        z-[60]
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