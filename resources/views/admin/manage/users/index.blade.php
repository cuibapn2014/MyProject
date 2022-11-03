@extends('layouts.layout_admin')
@section('title', 'Nhân sự')
@section('main')
@php
$current = 9;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Nhân sự
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-500 text-sm">{{ session('success') }}</p>
    @elseif(session('failed'))
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-500 text-sm">{{ session('failed') }}</p>
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
                @if($users->count() > 0)
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800 sticky top-0">
                        <th class="px-4 py-3 font-bold">#</th>
                        <th class="px-4 py-3">Avatar</th>
                        <th class="px-4 py-3">Tên</th>
                        <th class="px-4 py-3">Liên hệ</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Chức vụ</th>
                        <th class="px-4 py-3">Trực tuyến</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3">Ngày tham gia</th>
                        <th class="px-4 py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-[#ffffff] divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @php
                    $index = $users->firstItem();
                    @endphp
                    @foreach($users as $user)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 flex">
                            {{ $index }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <img v-tooltip.top-start="'{{ $user->name }}'"
                                src="{{asset('/img/user').'/'.$user->image }}"
                                class="h-12 w-12 object-cover object-center rounded-full" />
                        </td>
                        <td class="px-4 py-3 text-sm ">
                            {{ $user->name }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $user->phone ?? 'Chưa có' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $user->email ?? 'Chưa có' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $user->role->name }}
                        </td>
                        @if(Cache::has('user-' . $user->id))
                        <td class="px-4 py-3 text-sm">
                            <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-green-100 text-green-700 dark:bg-green-600">
                                Trực tuyến
                            </span>
                        </td>
                        @else
                        <td class="px-4 py-3 text-sm">
                            <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-gray-100 text-gray-700 dark:bg-gray-700">
                                Ngoại tuyến
                            </span>
                        </td>
                        @endif
                        @switch($user->status)
                        @case(1)
                        <td class="px-4 py-3 text-sm">
                            <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-green-100 text-green-700 dark:bg-green-600">
                                Đang sử dụng
                            </span>
                        </td>
                        @break
                        @case(2)
                        <td class="px-4 py-3 text-sm">
                            <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-orange-100 text-orange-700 dark:bg-orange-600">
                                Tạm khóa
                            </span>
                        </td>
                        @break
                        @case(3)
                        <td class="px-4 py-3 text-sm">
                            <span
                                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-red-100 text-red-700 dark:bg-red-600">
                                Ngưng sử dụng
                            </span>
                        </td>
                        @break
                        @endswitch
                        <td class="px-4 py-3 text-sm">
                            {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <button title="Chỉnh sửa"
                                class="flex items-center float-left justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Edit" @click="toggleCustomModal({{ json_encode($user) }})">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                    </path>
                                </svg>
                            </button>
                            <button title="Xóa" @click="openModal({{$user->id}})"
                                class="flex items-center float-left justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Delete">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
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
            {{ $users->links() }}
        </div>
    </div>
</div>

<transition enter-class="ease-out opacity-0" enter-to-class="opacity-100" leave-class="ease-in opacity-100"
    leave-to-class="opacity-0">
    <div v-show="this.isCustomModal" class="
        fixed
        inset-0
        z-30
        flex
        items-end
        transition duration-150
        bg-black bg-opacity-50
        sm:items-center sm:justify-center
      " id="backdrop-overlay" @click="toggleCustomModal()">
        <transition enter-class="ease-out opacity-0 transform translate-y-1/2" enter-to-class="opacity-100"
            leave-class="ease-in opacity-100" leave-to-class="opacity-0 transform translate-y-1/2">
            <!-- Modal -->
            <div v-show="this.isCustomModal" class="
          w-full
          px-6
          py-4
          overflow-hidden
          bg-[#ffffff]
          rounded-t-lg
          duration-150
          dark:bg-gray-800
          sm:rounded-lg sm:m-4 sm:max-w-xl
        " role="dialog" id="modal" @click.stop="">
                <form :action="'/admin/employee/update/' + objRequestProduct?.id" method="POST">
                    @csrf
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
            " aria-label="close" @click="toggleCustomModal()" type="button">
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
                            Cập nhật người dùng
                        </p>
                        <!-- Modal description -->
                        <div class="grid grid-cols-2 gap-3">
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Tên người dùng</span>
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
                                  " type="text" disabled :value="objRequestProduct?.name" />
                            </label>
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Số điện thoại</span>
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
                                  " type="text" disabled :value="objRequestProduct?.phone" />
                            </label>
                            <label class="block text-sm my-2">
                                <span class="text-gray-700 dark:text-gray-400">Trạng thái</span>
                                <select
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-select"
                                    name="status">
                                    <option value="1" :selected="objRequestProduct?.status == 1">Đang sử dụng</option>
                                    <option value="2" :selected="objRequestProduct?.status == 2">Tạm khóa</option>
                                    <option value="3" :selected="objRequestProduct?.status == 3">Ngưng sử dụng</option>
                                </select>
                            </label>
                            <label class="block text-sm my-2">
                                <span class="text-gray-700 dark:text-gray-400">Chức vụ</span>
                                <select
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-select"
                                    name="role">
                                    <option v-for="role in {{ json_encode($roles) }}" :key="role.id" :value="role.id"
                                        :selected="role.id == objRequestProduct?.role.id">[[
                                        role.name ]]</option>
                                </select>
                            </label>
                        </div>
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
                        <button type="button" @click="toggleCustomModal()" class="
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
            ">
                            Cập nhật
                        </button>
                    </footer>
                </form>
            </div>
        </transition>
    </div>

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
                        Xóa người dùng
                    </p>
                    <!-- Modal description -->
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Bạn có chắc chắn muốn xóa người dùng này ?
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
            " @click="handleDelete('/admin/user/delete/' + idDelete)">
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