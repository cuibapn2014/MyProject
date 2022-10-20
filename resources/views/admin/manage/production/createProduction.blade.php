@extends('layouts.layout_admin')
@section('title', 'Thêm mới |Đề nghị sản xuất')
@section('main')
@php
$current = 11;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Đề nghị sản xuất - Thêm mới
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    <form action="{{ route('admin.production.request.create') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-row items-center sm:flex-col">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Chọn đơn hàng <span class="text-red-500">*</span></span>
                <select class=" block
            w-full
            mt-1
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
            mb-1" name="detail_order_id" id="provider" aria-placeholder="Chọn đơn hàng">
                    <option value="" disabled selected>-- Chọn đơn hàng --</option>
                    @foreach($orders as $order)
                    @foreach($order->detail as $detail)
                    <option value="{{ $detail->id }}" {{ old('detail_order_id')==$detail->id ? 'selected'
                        :
                        null }}>{{ $order->customer->name . __(' - ') . $detail->product->Ten }}</option>
                        @endforeach
                    @endforeach
                </select>
                @error('detail_order_id')
                <span class="text-red-500 pt-2">{{ $message }}</span>
                @enderror
            </label>
            <label class="block text-sm mb-2 ml-4">
                <span class="text-gray-700 dark:text-gray-400">Mã đề nghị<span class="text-red-500">*</span></span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Nhập mã đề nghị" name="code"
                    value="{{ old('code') ?? __('DN') . rand(100000, 999999) }}" />
                @error('code')
                <span class="text-red-500 pt-2">{{ $message }}</span>
                @enderror
            </label>
            <label class="block text-sm mb-2 ml-4">
                <span class="text-gray-700 dark:text-gray-400">Mức độ ưu tiên<span class="text-red-500">*</span></span>
                <select class="
                block
                w-full
                mt-1
                text-sm
                dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
                form-select
                focus:border-purple-400
                focus:outline-none
                focus:shadow-outline-purple
                dark:focus:shadow-outline-gray
                mb-1
              " name="priority" id="priority" aria-placeholder="Chọn mức độ ưu tiên">
                    <option value="0" {{ old('priority') == 0 ? 'selected' : '' }}>Thấp</option>
                    <option value="1" {{ old('priority') == 1 ? 'selected' : '' }}>Bình thường</option>
                    <option value="2" {{ old('priority') == 2 ? 'selected' : '' }}>Cao</option>
                </select>
            </label>
        </div>
        <div class="upload__image block text-sm mb-3">
            <label class="text-gray-700 dark:text-gray-400">Hình ảnh</label>
            <input-file></input-file>
            @error('image.0')
            <span class="text-red-500 pt-2">{{ $message }}</span>
            @enderror
        </div>
        <label class="block text-sm my-2 mb-2">
            <span class="text-gray-700 dark:text-gray-400">Chọn sản phẩm<span class="text-red-500">*</span></span>
            <select class="
                block
                w-full
                mt-1
                text-sm
                dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
                form-select
                focus:border-purple-400
                focus:outline-none
                focus:shadow-outline-purple
                dark:focus:shadow-outline-gray
                mb-1
              " name="id_product" id="id_product" aria-placeholder="Chọn sản phẩm">
                <option value="">-- Chọn sản phẩm --</option>
                @foreach($product as $product)
                <option value="{{ $product->id }}">{{ $product->Ten }}</option>
                @endforeach
            </select>
            @error('id_ingredient')
            <span class="text-red-500 pt-2">{{ $message }}</span>
            @enderror
        </label>
        <div class="flex">
            <label class="block text-sm my-2">
                <span class="text-gray-700 dark:text-gray-400">Kích thước</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Nhập kích thước" name="size" value="{{ old('size') }}" />
            </label>
            <label class="block text-sm my-2 mx-2">
                <span class="text-gray-700 dark:text-gray-400">Màu sắc</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Nhập màu sắc" name="color" value="{{ old('color') }}" />
            </label>
            <label class="block text-sm my-2">
                <span class="text-gray-700 dark:text-gray-400">Số lượng <span class="text-red-500">*</span></span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    type="number" placeholder="Nhập số lượng" min="1" value="1" name="amount" />
                @error('amount')
                <span class="text-red-500 pt-2">{{ $message }}</span>
                @enderror
            </label>
        </div>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">Ghi chú</span>
            <textarea
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                rows="3" placeholder="Nhập ghi chú" name="note">{{ old('note') }}</textarea>
        </label>
        <div class="flex justify-start">
            <button class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 mx-2">Lưu</button>
            <button type="button" class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 cursor-pointer"
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