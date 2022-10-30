@extends('layouts.layout_admin')
@section('title', 'Bảng điều khiển')
@section('main')
@php
$current = 0;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Bảng điều khiển
    </h2>
    <!-- hover:h-[400px] hover:lg:h-[300px] hover:md:h-[300px] -->
    <!-- <div
        class="bg-gradient-to-r h-11 overflow-hidden duration-150 relative from-sky-500 to-indigo-500 my-2 text-white p-2 rounded-lg">
        <p class="font-semibold flex items-center text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <span class="mx-1">Cập nhật 2.0</span>
        </p>
        <ul class="list-disc font-semibold mx-4">
            <li class="my-2">Cập nhật giao diện</li>
            <li class="my-2">Cập nhật Quản lý công việc</li>
            <li class="my-2">Khách hàng - Theo dõi thông tin của khách hàng <span
                    class="bg-red-500 p-1 text-xs rounded-lg mx-1">Mới</span></li>
            <li class="my-2">Sản phẩm - Theo dõi và kiểm tra sản phẩm sản xuất bởi doanh nghiệp của bạn <span
                    class="bg-red-500 p-1 text-xs rounded-lg mx-1">Mới</span></li>
            <li class="my-2">Quản lý nhân sự - Kiểm soát cơ cấu tổ chức của bạn <span
                    class="bg-red-500 p-1 text-xs rounded-lg mx-1">Mới</span></li>
            <li class="my-2">Quản lý nhà cung cấp - Dễ dàng lựa chọn nguyên liệu, tối ưu vốn <span
                    class="bg-red-500 p-1 text-xs rounded-lg mx-1">Mới</span></li>
            <li class="my-2">Quản lý tài chính - Kiểm soát dòng tiền cho doanh nghiệp của bạn <span
                    class="bg-red-500 p-1 text-xs rounded-lg mx-1">Mới</span></li>
        </ul>
        <a href="http://zaloapp.com/qr/p/yie1866egwd6"
            class="flex absolute top-3 right-2 font-semibold items-center hover:text-gray-200 duration-150 hover:mr-2">
            <span>Liên hệ ngay</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div> -->
    @if($data_share['order_warning']->count() > 0)
    <div class="duration-150 relative bg-red-500 mb-2 text-white p-2 rounded-lg">
        <p class="font-semibold flex items-center text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <span class="mx-1">Có {{ $data_share['order_warning']->count() }} đơn hàng sắp đến hạn giao</span>
        </p>
        <a href="{{ route('admin.order.index') }}"
            class="flex absolute top-3 right-2 font-semibold items-center hover:text-gray-200 duration-150 hover:mr-2">
            <span>Chi tiết</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
    @endif
    <!-- Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card -->
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Khách
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format(count($countClient)) }}
                </p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Doanh thu
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($revenue->total) }} <sup>đ</sup>
                </p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Đơn hàng
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($countOrder->total) }}
                </p>
            </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Nợ công bán
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($debt->first()->debt) }} <sup>đ</sup>
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Nợ công mua
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($debt->last()->debt <= 0 ? 0 : $debt->last()->debt ) }} <sup>đ</sup>
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-100 dark:bg-indigo-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Đơn hàng chờ duyệt
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($countOrder->total) }}
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-100 dark:bg-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Thu/Chi chờ duyệt
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($finance) }}
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-100 dark:bg-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.504 1.132a1 1 0 01.992 0l1.75 1a1 1 0 11-.992 1.736L10 3.152l-1.254.716a1 1 0 11-.992-1.736l1.75-1zM5.618 4.504a1 1 0 01-.372 1.364L5.016 6l.23.132a1 1 0 11-.992 1.736L4 7.723V8a1 1 0 01-2 0V6a.996.996 0 01.52-.878l1.734-.99a1 1 0 011.364.372zm8.764 0a1 1 0 011.364-.372l1.733.99A1.002 1.002 0 0118 6v2a1 1 0 11-2 0v-.277l-.254.145a1 1 0 11-.992-1.736l.23-.132-.23-.132a1 1 0 01-.372-1.364zm-7 4a1 1 0 011.364-.372L10 8.848l1.254-.716a1 1 0 11.992 1.736L11 10.58V12a1 1 0 11-2 0v-1.42l-1.246-.712a1 1 0 01-.372-1.364zM3 11a1 1 0 011 1v1.42l1.246.712a1 1 0 11-.992 1.736l-1.75-1A1 1 0 012 14v-2a1 1 0 011-1zm14 0a1 1 0 011 1v2a1 1 0 01-.504.868l-1.75 1a1 1 0 11-.992-1.736L16 13.42V12a1 1 0 011-1zm-9.618 5.504a1 1 0 011.364-.372l.254.145V16a1 1 0 112 0v.277l.254-.145a1 1 0 11.992 1.736l-1.735.992a.995.995 0 01-1.022 0l-1.735-.992a1 1 0 01-.372-1.364z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Đề nghị sản xuất
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($productionRequest) }}
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-100 dark:bg-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    <path
                        d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Đề xuất mua hàng
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($requirement) }}
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-100 dark:bg-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Nhập kho/Xuất kho
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($warehouse) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Biểu đồ
    </h2>
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Thống kê các đơn hàng trong năm {{ date('Y') }}
            </h4>
            <canvas id="pie"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <!-- Chart legend -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-blue-500 rounded-full"></span>
                    <span>Đã hủy</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-600 rounded-full"></span>
                    <span>Đang xử lý</span>
                </div>
                <!-- <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                    <span>Bags</span>
                </div> -->
            </div>
        </div>
        <div class="min-w-0 p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Doanh thu trong năm {{ date('Y') }}
            </h4>
            <canvas id="line"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <!-- Chart legend -->
                <!-- <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-600 rounded-full"></span>
                    <span>Organic</span>
                </div> -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                    <span>Doanh thu</span>
                </div>
            </div>
        </div>
        <!-- Bars chart -->
        <div class="min-w-0 p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Thống kê đơn hàng trong năm {{ date('Y') }}
            </h4>
            <canvas id="bars"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <!-- Chart legend -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                    <span>Khách hàng</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                    <span>Doanh thu ước tính</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- <script src="{{ asset('js/charts-pie.js') }}" defer></script> -->
<!-- <script src="{{ asset('js/charts-lines.js') }}" defer></script> -->
@endsection