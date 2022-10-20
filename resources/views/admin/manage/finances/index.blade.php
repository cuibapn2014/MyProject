@extends('layouts.layout_admin')
@section('title', 'Tài chính')
@section('main')
@php
$current = 8;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Tài chính
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    <div class="flex justify-end py-2">
        <div class="inline-block relative group mx-2">                           
            <ul class="absolute hidden text-gray-700 pt-1 right-0 top-[50] group-hover:block z-50" style="margin-top: 35px;">
                <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap text-gray-700"
                        href="{{ route('admin.finance.create') }}">Phiếu thu</a></li>
                <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap text-gray-700"
                    href="{{ route('admin.finance.create') }}?type=1">Phiếu chi</a></li>
            </ul>
            <button onclick=""
            class="flex items-center h-full px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border-0 rounded-lg active:bg-purple-700 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Tạo mới
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
        </button>
        </div>
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
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                @if($finances->count() > 0)
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 font-bold">#</th>
                        <th class="px-2 py-3">Mã phiếu</th>
                        <th class="px-2 py-3">Loại phiếu</th>
                        <th class="px-4 py-3">Tên chi phí</th>
                        <th class="px-4 py-3">Nội dung</th>
                        <th class="px-4 py-3">Số tiền</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3">Ngày tạo</th>
                        <th class="px-4 py-3">Ngày duyệt</th>
                        <th class="px-4 py-3">Người duyệt</th>
                        <th class="px-4 py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-[#ffffff] divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @php
                    $index = $finances->firstItem();
                    @endphp
                    @foreach($finances as $finance)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 flex">  
                            {{ $index }}                     
                        </td>
                        <td class="px-2 py-3 text-sm">
                            {{$finance->code}}
                        </td>
                        <td class="px-2 py-3 text-sm">
                            {{$finance->type == 1 ? 'Phiếu thu' : 'Phiếu chi'}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{$finance->title}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{$finance->detail}}
                        </td>
                        <td class="px-4 py-3 text-sm {{ $finance->type==1 ? 'text-green-500' : 'text-red-500'}}">
                            {{ $finance->type==1 ? '+' : '-'}}{{number_format($finance->total,0,',','.')}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @switch($finance->status)
                            @case(1)
                            <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-orange-100 text-orange-700 dark:bg-orange-600">
                                Chờ duyệt
                            </span>
                            @break
                            @case(2)
                            <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-green-100 text-green-700 dark:bg-green-600">
                                Đã duyệt
                            </span>
                            @break
                            @default
                            <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-red-100 text-red-700 dark:bg-red-600">
                                Không duyệt
                            </span>
                            @break
                            @endswitch
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{\Carbon\Carbon::parse($finance->create_date)->format('d/m/Y')}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $finance->reviewer_date ? \Carbon\Carbon::parse($finance->reviewer_date)->format('d/m/Y') : ''}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <img v-tooltip.top-start="'{{ $finance->user->name }} - {{ $finance->user->role->name }}'"
                            src="{{asset('/img/user').'/'.$finance->user->image }}"
                            class="h-12 w-12 object-cover object-center rounded-full" />
                        </td>
                        <td class="px-4 py-3 text-sm flex items-center">
                            @if($finance->status == 1)
                            <button v-tooltip="'Chỉnh sửa'" title="Chỉnh sửa"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Edit"
                                onclick="location.href='{{ route('admin.finance.update',['id' => $finance->id]) }}?type={{ $finance->type }}'">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                    </path>
                                </svg>
                            </button>
                            @endif
                            <button v-tooltip="'Xóa'" title="Xóa" @click="openModal({{$finance->id}})"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Delete">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            @if($finance->status == 1)
                            <div class="inline-block relative group">                           
                                <ul class="absolute hidden text-gray-700 pt-1 right-0 top-[25] group-hover:block z-50" style="margin-top: 25px;">
                                    <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap text-gray-700"
                                            href="{{ route('admin.finance.updateStatus', ['id' => $finance->id, 'status' => 2]) }}">Duyệt</a></li>
                                    <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap text-gray-700"
                                        href="{{ route('admin.finance.updateStatus', ['id' => $finance->id, 'status' => 3]) }}">Không duyệt</a></li>
                                </ul>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                            </div>  
                            @endif                       
                        </td>
                    </tr>
                    @php $index++; @endphp
                    @endforeach
                </tbody>
                @else
                <div class="text-sm text-center dark:text-gray-200">Không tìm thấy dữ liệu nào</div>
                @endif
            </table>
        </div>
    </div>
</div>
<transition enter-class="opacity-0" enter-to-class="opacity-100" leave-to-class="opacity-0">
    <quota-modal v-if="isModalQuota" class="z-50 transition ease-in-out duration-150"
        :product="objProduct" @toggle-profile="toggleQuotaModal">
    </quota-modal>
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
                        Xóa
                    </p>
                    <!-- Modal description -->
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Bạn có chắc chắn muốn xóa ?
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
            " @click="handleDelete('/admin/finances/delete/')">
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