@extends('layouts.layout_admin')
@section('title', 'Quản lý loại vải')
@section('main')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Quản lý loại vải
    </h2>
    <div class="flex justify-end py-2">
        <button
            class="flex items-center px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border-0 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Thêm mới
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
            </svg>
        </button>
    </div>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                @if($fabric->count() > 0)
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Tên</th>
                        <th class="px-4 py-3">Màu sắc</th>
                        <th class="px-4 py-3">Tính chất</th>
                        <th class="px-4 py-3">Giá</th>
                        <th class="px-4 py-3">Ghi Chú</th>
                        <th class="px-4 py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-[#ffffff] divide-y dark:divide-gray-700 dark:bg-gray-800">

                    @foreach($fabric as $fabric)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            {{$fabric->Ten}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{$fabric->MauSac}}
                        </td>
                        <td class="px-4 py-3 text-sm text-ellipsis overflow-hidden w-48"
                            style="max-width: 200px;text-overflow:ellipsis" title="{{$fabric->TinhChat}}">
                            {{$fabric->TinhChat}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{number_format($fabric->Gia)}}đ
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{$fabric->GhiChu}}
                        </td>
                        <td class="px-4 py-3 text-sm flex items-center">
                            <button title="Chỉnh sửa"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Edit">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                    </path>
                                </svg>
                            </button>
                            <button title="Xóa"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Delete">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                <div class="text-sm text-center">Không tìm thấy dữ liệu nào</div>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection