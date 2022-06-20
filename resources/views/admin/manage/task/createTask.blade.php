@extends('layouts.layout_admin')
@section('title', 'Thêm mới | Công Việc')
@section('main')
@php
$current = 4;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Công việc - Thêm công việc
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    @if($errors->any())
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ $errors->first() }}</p>
    @endif
    <form action="{{ route('admin.task.request.create') }}" method="post">
        @csrf
        <div class="px-4 py-3 mb-8 bg-[#ffffff] rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tiêu đề</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="" name="title" />
            </label>
            <label class="block mt-2 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Chi tiết công việc</span>
                <textarea class="
                    block
                    w-full
                    mt-1
                    text-sm
                    dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
                    form-textarea
                    focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
                    dark:focus:shadow-outline-gray
                  " rows="3" placeholder="" name="detail"></textarea>
            </label>

            <span class="mt-4 dark:text-gray-200">Nhân viên làm</span>
            <div class="max-h-64 overflow-auto border bg-gray-50 rounded-md">
                @if($users->count() > 0)
                <div class="flex text-sm p-1 bg-gray-200">
                    <label class="flex items-center dark:text-gray-400">
                        <input type="checkbox"
                            class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            @change="toggleCheckAll" />
                        <span class="mx-2">Chọn tất cả</span>
                    </label>
                </div>
                @foreach($users as $user)
                <div class="flex px-2 py-3 text-sm p-2 border-bottom">
                    <label class="flex items-center dark:text-gray-400">
                        <input type="checkbox"
                            class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            name="users[]" value="{{ $user->id }}" :checked="this.checkAll" />
                        <div class="flex items-center mx-2">
                            <img src="{{ asset('/img/user').'/'.$user->image }}"
                                class="h-9 w-9 rounded-full object-cover" />
                            <span class="mx-2">{{ $user->name }}</span>
                        </div>
                    </label>
                </div>
                @endforeach
                @endif
            </div>
            <label class="block text-sm my-2 lg:w-1/4">
                <span class="flex text-gray-700 dark:text-gray-400">Thời hạn hoàn thành</span>
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
                      " type="date" name="duration" placeholder="" />
            </label>

            <div class="flex justify-end">
                <button class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 mx-2">Thêm công việc</button>
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
                        Xác nhận
                    </p>
                    <!-- Modal description -->
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Bạn có chắn chắn muốn hủy bỏ công việc này ?
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
            " @click="this.location.href='/admin/task'">
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