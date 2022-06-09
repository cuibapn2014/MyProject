@extends('layouts.layout_admin')
@section('title', 'Thêm mới |Quản lý đơn hàng')
@section('main')
@php
$current = 1;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Quản lý đơn hàng - Thêm đơn hàng mới
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @endif
    @if($errors->any())
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ $errors->first() }}</p>
    @endif
    <form action="{{route('admin.order.request.create')}}" method="post" enctype="multipart/form-data">
        @csrf
        <add-order></add-order>
    </form>
</div>
@endsection