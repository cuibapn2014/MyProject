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
    <form action="{{ url()->current() }}" method="GET" class="flex my-2">
        <input class="
        block
        w-48
        text-sm
        dark:border-gray-600 dark:bg-gray-700
        focus:border-purple-400
        focus:outline-none
        focus:shadow-outline-purple
        dark:text-gray-300 dark:focus:shadow-outline-gray
        rounded-l-md
        form-input
        " type="text" name="keyword" placeholder="Nhập tìm kiếm.." />
        <button
            class="flex items-center px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border-0 rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </form>
    <div class="w-full overflow-x-auto rounded-lg shadow-xs mb-4" v-dragscroll style="max-height: 600px;">
        <div class="w-full">
            <table class="w-full whitespace-no-wrap">
                @if($requirements->count() > 0)
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800 sticky top-0">
                        <th class="px-3 py-3 font-bold">#</th>
                        <th class="px-1 py-3">Đề nghị sản xuất</th>
                        <th class="px-4 py-3">Nguyên vật liệu</th>
                        <th class="px-1 py-3">Loại</th>
                        <th class="px-4 py-3 text-center">Nhà cung cấp</th>
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
                        <td class="px-3 py-3 flex">
                            {{ $index }}
                        </td>
                        <td class="px-1 py-3 text-sm">
                            {{ $requirement->production_request->code }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $requirement->ingredient->Ten }}
                        </td>
                        <td class="px-1 py-3 text-sm">
                            {{ $requirement->ingredient->ingredient_type->name }}
                        </td>
                        <td class="px-4 py-3 text-sm text-center">
                            {{ $requirement->ingredient->provider->name }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $requirement->amount . ' (' . $requirement->ingredient->unit_cal->name.')' }}
                        </td>
                        <td class="px-4 py-3 text-xs">
                            
                                @switch($requirement->status)
                                @case(1)
                                <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-orange-100 dark:bg-orange-600 text-orange-700">
                                Chờ xử lý
                                @break
                                @case(2)
                                <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-purple-100 dark:bg-purple-600 text-purple-700">
                                Đã xử lý
                                @break
                                @case(3)
                                <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-green-100 dark:bg-green-600 text-green-700">
                                Đã nhập kho
                                @break
                                @case(4)
                                <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-red-100 dark:bg-red-600 text-red-700">
                                Đã hủy bỏ
                                @break
                                @default
                                <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-gray-600">
                                Không xác định
                                @break
                                @endswitch
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{
                            \Carbon\Carbon::parse($requirement->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y')
                            }}
                        </td>
                        <td class="px-4 py-3 text-sm flex items-center">
                            @if($requirement->status < 2)
                            <button v-tooltip="'Đã xử lý'" title="Đã xử lý"
                            onclick="location.href='{{ route('admin.requirement.updateStatus', ['id' => $requirement->id]) }}?status=2'"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Done">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                  </svg>
                            </button>
                            <button v-tooltip="'Không xử lý'" title="Không xử lý"
                            onclick="location.href='{{ route('admin.requirement.updateStatus', ['id' => $requirement->id]) }}?status=4'"
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Cancel">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                              </svg>
                            </button>
                            @elseif($requirement->status == 2)
                            <button v-tooltip="'Đã nhập kho'" title="Đã nhập kho"
                            onclick="location.href='{{ route('admin.requirement.updateStatus', ['id' => $requirement->id]) }}?status=3'"
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Import">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                              </svg>
                            </button>
                            @endif
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