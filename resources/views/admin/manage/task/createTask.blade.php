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
                            @change="toggleCheckAll"/>                
                            <span class="mx-2">Chọn tất cả</span>
                    </label>
                </div>
                @foreach($users as $user)
                <div class="flex px-2 py-3 text-sm p-2 border-bottom">
                    <label class="flex items-center dark:text-gray-400">
                        <input type="checkbox"
                            class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" 
                            name="users[]"
                            value="{{ $user->id }}"
                            :checked="this.checkAll"/>
                        <div class="flex items-center mx-2">
                            <img src="{{ asset('/img/user').'/'.$user->image }}" class="h-9 w-9 rounded-full object-cover"/>
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
@endsection