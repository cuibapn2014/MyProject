@extends('layouts.layout_admin')
@section('title', 'Bảng điều khiển')
@section('main')
@php
$current = 0;
@endphp
<div class="container px-6 mx-auto grid h-full text-center">
    <!-- <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Bảng điều khiển
    </h2> -->
    <!-- Cards -->
    <span class="h-full flex items-center text-center w-full justify-center text-lg dark:text-gray-200">Chào mừng bạn đến với website Lynhouse</span>
   <!-- <iframe src="{{asset('/admin/invoice/3')}}" width="575px" height="775px" class="border mx-auto scale-75" frameborder="0"></iframe> -->
</div>
@endsection
@section('script')
<script src="{{ asset('js/charts-pie.js') }}" defer></script>
<script src="{{ asset('js/charts-lines.js') }}" defer></script>
@endsection