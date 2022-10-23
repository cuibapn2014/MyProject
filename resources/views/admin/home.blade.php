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
    <div
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
    </div>
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
                    Nợ công
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ number_format($debt->sum('debt')) }} <sup>đ</sup>
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
                Tổng số lượng loại hàng được mua trong năm {{ date('Y') }}
            </h4>
            <canvas id="pie"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <!-- Chart legend -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-blue-500 rounded-full"></span>
                    <span>Hàng may</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-600 rounded-full"></span>
                    <span>Hàng mẫu</span>
                </div>
                <!-- <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                    <span>Bags</span>
                </div> -->
            </div>
        </div>
        <div class="min-w-0 p-4 bg-[#ffffff] rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Doanh thu từ đầu năm {{ date('Y') }}
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
                Tổng nợ công trong năm {{ date('Y') }}
            </h4>
            <canvas id="bars"></canvas>
            <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                <!-- Chart legend -->
                <div class="flex items-center">
                    <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                    <span>Nợ công</span>
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