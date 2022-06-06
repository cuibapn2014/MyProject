@extends('layouts.layout_admin')
@section('title', 'Chỉnh sửa |Quản lý đơn hàng')
@section('main')
@php
$current = 1;
@endphp
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Quản lý đơn hàng - Chỉnh sửa
    </h2>
    @if(session('success'))
    <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
    @elseif(session('error'))
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ session('error') }}</p>
    @endif
    @if($errors->any())
    <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ $errors->first() }}</p>
    @endif
    <form action="{{route('admin.order.request.update',['id' => $order->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        <edit-order order="{{$order}}"></edit-order>
    </form>
</div>

</div>
@endsection