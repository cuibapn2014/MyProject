@extends('layouts.layout_admin')
@section('title', 'Công việc')
@section('main')
@php
$current = 4;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Công việc
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    <task v-if="this.countTask > 0" :assign="this.dataTask"></task>
    <p v-else class="dark:text-gray-200 text-center">Không tìm thấy dữ liệu nào</p>
</div>

@endsection