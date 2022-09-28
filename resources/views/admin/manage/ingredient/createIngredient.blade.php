@extends('layouts.layout_admin')
@section('title', 'Thêm mới | Nguyên phụ liệu')
@section('main')
@php
$current = 3;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Nguyên phụ liệu - Thêm mới
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    @if($errors->any())
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ $errors->first() }}</p>
    @endif
    <form action="{{route('admin.ingredient.request.create')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="px-4 py-3 mb-8 bg-[#ffffff] rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tên Nguyên phụ liệu</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="" name="name" />
            </label>

            <div class="upload__image block text-sm mb-3">
                <label class="text-gray-700 dark:text-gray-400">Hình ảnh</label>
                <input-file v-if="display >= 0"></input-file>
                <input-file v-if="display >= 1"></input-file>
                <input-file v-if="display >= 2"></input-file>
            </div>
            <a v-if="this.display <= 1" class="btn__add--input p-2 bg-indigo-600 rounded-lg text-white my-2"
                @click="handleClick">Thêm ảnh</a>
                <label class="block text-sm mt-4 mb-2">
                    <span class="text-gray-700 dark:text-gray-400">Loại</span>
                    <select class=" block
                    w-full
                    mt-1
                    text-sm
                    dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
                    form-select
                    focus:border-purple-400
                    focus:outline-none
                    focus:shadow-outline-purple
                    dark:focus:shadow-outline-gray" name="id_ingredient_type" id="id_ingredient_type" aria-placeholder="Chọn đơn loại">
                    <option value="">-- Chọn loại --</option>
                    @foreach($ingredientTypes as $type)
                    <option value="{{ $type->id }}" {{ old('id_ingredient_type') == $type->id ? 'selected' : null }}>{{ $type->name }}</option>
                    @endforeach
                </select>
                </label>
                <label class="block text-sm mt-4 mb-2">
                    <span class="text-gray-700 dark:text-gray-400">Đơn vị tính</span>
                    <select class=" block
                    w-full
                    mt-1
                    text-sm
                    dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
                    form-select
                    focus:border-purple-400
                    focus:outline-none
                    focus:shadow-outline-purple
                    dark:focus:shadow-outline-gray" name="id_unit" id="id_unit" aria-placeholder="Chọn đơn vị tính">
                    <option value="">-- Chọn đơn vị tính --</option>
                    @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('id_unit') == $unit->id ? 'selected' : null }}>{{ $unit->name }}</option>
                    @endforeach
                </select>
                </label>
            <label class="block text-sm mt-3">
                <span class="text-gray-700 dark:text-gray-400">Giá</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="" name="price" />
            </label>
            <label class="block text-sm mt-4 mb-2">
                <span class="text-gray-700 dark:text-gray-400">Nhà cung cấp</span>
                <select class=" block
                w-full
                mt-1
                text-sm
                dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
                form-select
                focus:border-purple-400
                focus:outline-none
                focus:shadow-outline-purple
                dark:focus:shadow-outline-gray" name="provider" id="provider" aria-placeholder="Chọn nhà cung cấp">
                <option value="">-- Chọn nhà cung cấp --</option>
                @foreach($providers as $provider)
                <option value="{{ $provider->id }}" {{ old('provider') == $provider->id ? 'selected' : null }}>{{ $provider->name }}</option>
                @endforeach
            </select>
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Ghi chú</span>
                <textarea
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="3" placeholder="" name="note"></textarea>
            </label>
            <div class="flex justify-end">
                <button class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 mx-2">Thêm Nguyên phụ liệu</button>
                <a class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 cursor-pointer"
                    @click="openModal">Quay về</a>
            </div>
        </div>
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
                    <a href="{{ route('admin.ingredient.index') }}"
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
@section('script')
<script src="{{ asset('js/script.js') }}" defer></script>
@endsection