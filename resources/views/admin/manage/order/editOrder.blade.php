@extends('layouts.layout_admin')
@section('title', 'Chỉnh sửa |Đơn hàng')
@section('main')
@php
$current = 1;
@endphp
<div class="container px-6 mx-auto grid" id="edit-order" data-id="{{ $order->id }}">

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Đơn hàng - Chỉnh sửa
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @elseif(session('error'))
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ session('error') }}</p>
    @endif
    @if($errors->any())
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ $errors->first() }}</p>
    @endif
    <form action="{{route('admin.order.request.update',['id' => $order->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="px-4 py-3 mb-8 bg-[#ffffff] rounded-lg shadow-md dark:bg-gray-800">
            <h3 class="my-1 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Thông tin khách hàng
            </h3>
            <label class="block text-sm mx-2 w-96">
                <span class="flex text-gray-700 dark:text-gray-400">Khách hàng
                    <p class="text-red-500 mx-1">*</p>
                </span>
                <select class="
            block
            w-full
            mt-1
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
          " name="id_customer">
                    <option disabled value="">Chọn khách hàng</option>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $order->id_customer == $customer->id ? 'selected' : null }}>{{ $customer->name . ' - ' . $customer->phone_number }}
                    </option>
                    @endforeach
                </select>
            </label>
            <h3 class="mt-4 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Thông tin đơn hàng
            </h3>
            <div v-for="product in this.countProductEdit" :key="product.id" class="flex md:flex-row items-center">
                <label class="block text-sm mx-2 col-span-4">
                    <span class="flex text-gray-700 dark:text-gray-400">Sản phẩm
                        <p class="text-red-500 mx-1">*</p>
                    </span>
                    <select class="
            block
            w-full
            max-h-10
            mt-1
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
          " name="id_product[]" v-model="product.id_product">
                        <option disabled value="">Chọn sản phẩm</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" :selected="product.id_product == {{ $product->id }}" >
                            {{ $product->Ten }} - Giá thành: {{ number_format_str($product->GiaThanh) }}
                        </option>
                        @endforeach
                    </select>
                </label>
                [[ product.id_product == {{ $product->id }} ]]
                <label class="block text-sm my-1 mx-2">
                    <span class="flex text-gray-700 dark:text-gray-400">Số lượng
                        <p class="text-red-500 mx-1">*</p>
                    </span>
                    <input class="
              block
              w-full
              mt-1
              text-sm
              dark:border-gray-600 dark:bg-gray-700
              focus:border-purple-400
              focus:outline-none
              focus:shadow-outline-purple
              dark:text-gray-300 dark:focus:shadow-outline-gray
              form-input
            " type="number" min="1" placeholder="" v-model="product.amount" name="quantity[]" />
                </label>
                <label class="block text-sm my-1 mx-2">
                    <span class="flex text-gray-700 dark:text-gray-400">Đơn giá
                        <p class="text-red-500 mx-1">*</p>
                    </span>
                    <input class="
              block
              w-full
              mt-1
              text-sm
              dark:border-gray-600 dark:bg-gray-700
              focus:border-purple-400
              focus:outline-none
              focus:shadow-outline-purple
              dark:text-gray-300 dark:focus:shadow-outline-gray
              form-input
            " type="number" min="1" placeholder="" v-model="product.price" name="price[]" />
                </label>
                <label class="block my-2 text-sm">
                    <span class="flex text-gray-700 dark:text-gray-400">
                        Chất lượng hàng
                        <p class="text-red-500 mx-1">*</p>
                    </span>
                    <select class="
          block
          w-full
          mt-1
          text-sm
          dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
          form-select
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:focus:shadow-outline-gray
        " name="quality[]" v-model="product.id_ChatLuong">
                        <option selected value="">Chọn chất lượng</option>
                        <option value="1" :selected="product.id_ChatLuong == 1">Thường</option>
                        <option value="2" :selected="product.id_ChatLuong == 2">Cao</option>
                    </select>
                </label>
            </div>
            <div class="flex">
                <button type="button" @click="this.handleClickAddProductObj"
                    class="px-3 py-2 mr-2 rounded-md text-white bg-indigo-500 flex justify-center items-center hover:bg-indigo-600 duration-150">
                    <span>Thêm</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg></button>
                <button type="button" @click="this.handleMinusProductObj"
                    class="px-3 py-2 rounded-md text-white bg-red-500 flex justify-center items-center hover:bg-red-600 duration-150">
                    <span>Bớt</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center">
                <label class="block text-sm my-1 mr-2 w-48">
                    <span class="flex text-gray-700 dark:text-gray-400">Tổng tiền
                    </span>
                    <input class="
          block
          w-full
          mt-1
          text-sm
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400
          focus:outline-none
          focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        " type="text" readonly name="total" placeholder="" :value="this.totalPricEdit.toLocaleString('vi-vn')" />
                </label>
                <label class="block text-sm my-2 mx-2">
                    <span class="flex text-gray-700 dark:text-gray-400"> Thuế (%VAT)
                    </span>
                    <input class="
          block
          w-16
          mt-1
          text-sm
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400
          focus:outline-none
          focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        " type="number" min="0" max="100" value="{{ $order->vat }}" name="vat" />
                </label>
                <label class="block text-sm my-1 mx-2">
                    <span class="flex text-gray-700 dark:text-gray-400">Đã thanh toán
                    </span>
                    <input class="
          block
          w-48
          mt-1
          text-sm
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400
          focus:outline-none
          focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        " type="number" name="paid" placeholder="" value="{{ $order->paid }}" step="1000" />
                </label>
            </div>
            <label class="block text-sm my-1 lg:w-1/4">
                <span class="flex text-gray-700 dark:text-gray-400">Ngày giao hàng</span>
                <input class="
          block
          w-full
          mt-1
          text-sm
          disabled:bg-gray-50
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        " type="date" name="delivery_date" placeholder=""  value="{{ \Carbon\Carbon::parse($order->NgayTraDon)->toDateString() }}"/>
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Yêu cầu khách hàng</span>
                <textarea class="
          block
          w-full
          mt-1
          text-sm
          dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
          form-textarea
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:focus:shadow-outline-gray
        " rows="3" placeholder="" name="note">{{ $order->note }}</textarea>
            </label>
            <div class="flex justify-end">
                <button class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 mx-2">
                    Lưu thay đổi
                </button>
                <a class="
          mt-4
          text-white
          px-4
          py-2
          rounded-md
          border-0
          bg-indigo-600
          cursor-pointer
        " @click="this.openModal">Quay về</a>
            </div>
            <transition enter-class="ease-out opacity-0" enter-to-class="opacity-100" leave-class="ease-in opacity-100"
                leave-to-class="opacity-0">
                <div v-show="this.isModalOpen" class="
          fixed
          inset-0
          z-30
          flex
          items-end
          transition
          duration-150
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
                                <button class="
                  inline-flex
                  items-center
                  justify-center
                  w-6
                  h-6
                  text-gray-400
                  transition-colors
                  duration-150
                  rounded
                  dark:hover:text-gray-200
                  hover: hover:text-gray-700
                " aria-label="close" @click="closeModal">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img"
                                        aria-hidden="true">
                                        <path
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </header>
                            <!-- Modal body -->
                            <div class="mt-4 mb-6">
                                <!-- Modal title -->
                                <p class="
                  mb-2
                  text-lg
                  font-semibold
                  text-gray-700
                  dark:text-gray-300
                ">
                                    Xác nhận hủy thay đổi
                                </p>
                                <!-- Modal description -->
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    Mọi thứ chưa được lưu, bạn có chắc chắc muốn rời khỏi đây ?
                                </p>
                            </div>
                            <footer class="
                flex flex-row
                items-center
                justify-end
                px-6
                py-3
                -mx-6
                -mb-4
                space-y-4
                sm:space-y-0 sm:space-x-6 sm:flex-row
                bg-gray-50
                dark:bg-gray-800
              ">
                                <a href="/admin/order" class="
                  w-full
                  px-5
                  py-3
                  text-center
                  bg-purple-600
                  active:bg-purple-600
                  hover:bg-purple-700
                  focus:shadow-outline-purple
                  text-white text-sm
                  font-medium
                  decoration-transparent
                  leading-5
                  text-gray-700
                  transition-colors
                  duration-150
                  rounded-lg
                  dark:text-gray-400
                  sm:px-4 sm:py-2 sm:w-auto
                  focus:border-gray-500
                  active:text-gray-500
                  focus:outline-none focus:shadow-outline-gray
                ">
                                    Chắc chắn
                                </a>
                                <button @click.prevent="closeModal" class="
                  w-full
                  px-5
                  py-3
                  text-sm
                  font-medium
                  leading-5
                  text-[#000000]
                  dark:text-gray-200
                  transition-colors
                  duration-150
                  border
                  dark:border-0
                  border-gray-200
                  rounded-lg
                  sm:w-auto sm:px-4 sm:py-2
                  focus:outline-none
                ">
                                    Hủy bỏ
                                </button>
                            </footer>
                        </div>
                    </transition>
                </div>
            </transition>
        </div>
    </form>
</div>
@endsection