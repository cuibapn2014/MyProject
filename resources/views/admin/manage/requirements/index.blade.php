@extends('layouts.layout_admin')
@section('title', 'Đề xuất mua hàng')
@section('main')
@php
$current = 13;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Đề xuất mua hàng
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    <div class="flex justify-end py-2">
        <button onclick=""
            class="flex items-center px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border-0 rounded-lg active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-purple">
            Xuất Excel
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
        </button>
    </div>
    <div class="w-full overflow-x-auto rounded-lg shadow-xs mb-4" v-dragscroll style="max-height: 600px;">
        <div class="w-full">
            <table class="w-full whitespace-no-wrap">
                @if($requirements->count() > 0)
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800 sticky top-0">
                        <th class="px-4 py-3 font-bold">#</th>
                        <th class="px-4 py-3">Mã sản xuất</th>
                        <th class="px-4 py-3">Nguyên vật liệu</th>
                        <th class="px-4 py-3">Loại</th>
                        <th class="px-4 py-3">Nhà cung cấp</th>
                        <th class="px-4 py-3">Số lượng</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3">Ngày tạo</th>
                        <th class="px-4 py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-[#ffffff] divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @php
                    $index = $requirements->firstItem();
                    @endphp
                    @foreach($requirements as $requirement)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 flex">
                            {{ $index }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $requirement->production_request->code }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $requirement->ingredient->Ten }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $requirement->ingredient->ingredient_type->name }}
                        </td>
                        <td class="px-4 py-3 text-sm ">
                            {{ $requirement->ingredient->provider->name }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $requirement->amount . ' ' . $requirement->ingredient->unit_cal->name }}
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white {{ $requirement->status == 1 ? 'bg-orange-100 text-orange-700 dark:bg-orange-600' : 'bg-green-100 text-green-700 dark:bg-green-600' }}">
                            {{ $requirement->status == 1 ? 'Chờ xử lý' : ($requirement->status == 2 ? 'Đã xử lý' : 'Không giải quyết') }}
                            </span>
                        </td>                       
                        <td class="px-4 py-3 text-sm">
                            {{ \Carbon\Carbon::parse($requirement->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm flex items-center">              
                            <button v-tooltip="'Xử lý ngay'" title="Xử lý ngay"
                                @click.prevent="handleClickViewOrder({{ $requirement }})"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                        </td>
                    </tr>
                    @php
                    $index++;
                    @endphp
                    @endforeach
                </tbody>
                @else
                <div class="text-sm text-center dark:text-gray-200">Không tìm thấy dữ liệu nào</div>
                @endif
            </table>
            {{ $requirements->links() }}
        </div>
    </div>
</div>

<transition enter-class="ease-in opacity-0" enter-to-class="opacity-100" leave-class="ease-out opacity-100"
    leave-to-class="opacity-0">
    <modal-detail v-if="this.isOpenView" @toggle-detail="closeModalView" :order="this.detailOrder"
        class="transition duration-150">
    </modal-detail>
</transition>

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
                        Xóa đề nghị sản xuất
                    </p>
                    <!-- Modal description -->
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Bạn có chắc chắn muốn xóa đề nghị sản xuất này ?
                    </p>
                </div>
                <footer class="
            flex flex-col
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
                    <button class="
              w-full
              px-5
              py-3
              text-sm
              font-medium
              leading-5
              text-white
              transition-colors
              duration-150
              bg-purple-600
              border border-transparent
              rounded-lg
              sm:w-auto sm:px-4 sm:py-2
              active:bg-purple-600
              hover:bg-purple-700
              focus:outline-none focus:shadow-outline-purple
            " @click="handleDelete('/admin/plan/delete/' + idDelete)">
                        Chắc chắn
                    </button>
                    <button @click="closeModal" class="
              w-full
              px-5
              py-3
              text-sm
              font-medium
              leading-5
              text-gray-700
              transition-colors
              duration-150
              border border-gray-300
              rounded-lg
              dark:text-gray-400
              sm:px-4 sm:py-2 sm:w-auto
              active:bg-transparent
              hover:border-gray-500
              focus:border-gray-500
              active:text-gray-500
              focus:outline-none focus:shadow-outline-gray
            ">
                        Hủy bỏ
                    </button>
                </footer>
            </div>
        </transition>
    </div>

</transition>
@endsection