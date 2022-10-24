@extends('layouts.layout_admin')
@section('title', 'Lệnh sản xuất')
@section('main')
@php
$current = 12;
@endphp
<div class="container px-6 mx-auto grid">
  <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
    Lệnh sản xuất
  </h2>
  @if(session('success'))
  <p class="p-2 rounded-md my-2 bg-green-100 text-green-400 text-sm">{{ session('success') }}</p>
  @endif
  @if($errors->any())
  <p class="p-2 rounded-md my-2 bg-red-100 text-red-400 text-sm">{{ $errors->first() }}</p>
  @endif
  <div class="flex justify-end py-2">
    <button onclick=""
      class="flex items-center px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border-0 rounded-lg active:bg-green-700 hover:bg-green-700 focus:outline-none focus:shadow-outline-purple">
      Xuất Excel
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
      </svg>
    </button>
  </div>
  <div class="w-full overflow-x-auto rounded-lg shadow-xs mb-4" v-dragscroll style="max-height: 600px;">
    <div class="w-full">
      <table class="w-full whitespace-no-wrap">
        @if($plans->count() > 0)
        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800 sticky top-0">
            <th class="px-4 py-3 font-bold">#</th>
            <th class="px-4 py-3">Mã sản xuất</th>
            <th class="px-4 py-3">Mã lệnh</th>
            <th class="px-4 py-3">Sản phẩm</th>
            <th class="px-4 py-3">Loại</th>
            <th class="px-4 py-3">Công đoạn</th>
            <th class="px-4 py-3">Yêu cầu</th>
            <th class="px-4 py-3">Hoàn thành</th>
            <th class="px-4 py-3">Ưu tiên</th>
            <th class="px-4 py-3">Trạng thái</th>
            <th class="px-4 py-3">Ngày tạo</th>
            <th class="px-4 py-3">Hành động</th>
          </tr>
        </thead>
        <tbody class="bg-[#ffffff] divide-y dark:divide-gray-700 dark:bg-gray-800">
          @php
          $index = $plans->firstItem();
          @endphp
          @foreach($plans as $plan)
          <tr class="text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3 flex">
              {{ $index }}
            </td>
            <td class="px-4 py-3 text-sm">
              {{ $plan->production_request->code }}
            </td>
            <td class="px-4 py-3 text-sm">
              {{ $plan->code }}
            </td>
            <td class="px-4 py-3 text-sm ">
              {{ $plan->product->Ten }}
            </td>
            <td class="px-4 py-3 text-sm ">
              {{ $plan->product->ingredient_type->name }}
            </td>
            <td class="px-4 py-3 text-sm ">
              {{ $plan->product->stage_product->name }}
            </td>
            <td class="px-4 py-3 text-sm">
              {{ number_format($plan->require_total, 0, ',', '.') . ' ' . $plan->product->unit_cal->name }}
            </td>
            <td class="px-4 py-3 text-sm">
              {{ number_format($plan->produced->sum('amount')) . ' ' . $plan->product->unit_cal->name }}
            </td>
            <td class="px-4 py-3 text-sm flex items-center">
              @if($plan->priority == 0)
              <span>Thấp</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                  clip-rule="evenodd" />
              </svg>
              @elseif($plan->priority == 1)
              <span>Trung bình</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M4.293 15.707a1 1 0 010-1.414l5-5a1 1 0 011.414 0l5 5a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 0zm0-6a1 1 0 010-1.414l5-5a1 1 0 011.414 0l5 5a1 1 0 01-1.414 1.414L10 5.414 5.707 9.707a1 1 0 01-1.414 0z"
                  clip-rule="evenodd" />
              </svg>
              @else
              <span>Cao</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M4.293 15.707a1 1 0 010-1.414l5-5a1 1 0 011.414 0l5 5a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 0zm0-6a1 1 0 010-1.414l5-5a1 1 0 011.414 0l5 5a1 1 0 01-1.414 1.414L10 5.414 5.707 9.707a1 1 0 01-1.414 0z"
                  clip-rule="evenodd" />
              </svg>
              @endif
            </td>
            <td class="px-4 py-3 text-sm">
              @php
              $status = $plan->produced->sum('amount') == $plan->require_total && $plan->production_request->status == 2
              ? 3 : $plan->production_request->status;
              @endphp
              @switch($status)
              @case(1)
              <span
                class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700">
                Chờ xử lý
              </span>
              @break
              @case(2)
              <span
                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-orange-100 text-orange-700 dark:bg-orange-600">
                Đang sản xuất
              </span>
              @break
              @case(3)
              <span
                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-green-100 text-green-700 dark:bg-green-600">
                Hoàn thành
              </span>
              @break
              @case(4)
              <span
                class="px-2 py-1 font-semibold leading-tight rounded-full dark:text-white bg-red-100 text-red-700 dark:bg-red-600">
                Ngưng sản xuất
              </span>
              @break
              @endswitch
            </td>
            <td class="px-4 py-3 text-sm">
              {{ \Carbon\Carbon::parse($plan->updated_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y')
              }}
            </td>
            <td class="px-4 py-3 text-sm flex items-center">
              @if($status == 2)
              <button title="Cập nhật" v-tooltip="'Cập nhật'"
                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                aria-label="Edit" @click="toggleUpdateAmountModal({{ $plan->load(['produced', 'produced.user_create']) }})">
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                  </path>
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
      {{ $plans->links() }}
    </div>
  </div>
</div>

<transition enter-class="ease-in opacity-0" enter-to-class="opacity-100" leave-class="ease-out opacity-100"
  leave-to-class="opacity-0">
  <div v-if="this.idProduction != null"
    class="w-full h-full fixed top-0 left-0 flex items-center backdrop-blur-lg z-[100] duration-150"
    @keydown.esc="toggleUpdateAmountModal(null)" @click="toggleUpdateAmountModal(null)">
    <div class="
        profile__modal
        lg:w-2/5
        w-full
        h-fit
        overflow-y-auto
        flex flex-col
        bg-[#ffffff]
        mx-auto
        rounded-lg
        p-4
        z-50
        shadow
        dark:bg-gray-800 dark:text-gray-200
      " @click.stop="">
      <div class="
          flex
          items-center
          justify-between
          border-bottom border-gray-200
          py-2
        ">
        <h2 class="text-2xl font-bold">Cập nhật số lượng sản xuất</h2>
        <button class="rounded-lg border border-opacity-75" @click="toggleUpdateAmountModal(null)">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="flex justify-between my-3">
        <div class="text-base grow pl-2 flex flex-col">
          <form :action="'/admin/plan/update-completed'" method="post">
            @csrf
            <input type="hidden" name="id_production" :value="this.idProduction.id">
            <div class="grid gap-2 grid-cols-2 mb-4">
              <label class="block text-sm my-2 mx-2">
                <span class="text-gray-700 dark:text-gray-400">Lô <span class="text-red-500">*</span></span>
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
                  " type="text" placeholder="Nhập lô sản xuất" name="lot_number" />
              </label>
              <label class="block text-sm my-2 mx-2">
                <span class="text-gray-700 dark:text-gray-400">Số lượng <span class="text-red-500">*</span></span>
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
                  " type="number" placeholder="Nhập số lượng" min="1" value="1" name="amount" />
              </label>
              <label class="block text-sm my-2 mx-2">
                <span class="text-gray-700 dark:text-gray-400">Ngày bắt đầu <span class="text-red-500">*</span></span>
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
                  " type="date" placeholder="Chọn ngày bắt đầu" value="{{ \Carbon\Carbon::parse()->format('Y-m-d') }}"
                  name="start_date" />
              </label>
              <label class="block text-sm my-2 mx-2">
                <span class="text-gray-700 dark:text-gray-400">Ngày kết thúc <span class="text-red-500">*</span></span>
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
                  " type="date" placeholder="Chọn ngày kết thức" name="end_date" />
              </label>
            </div>
            <div class="flex items-center justify-end text-sm">
              <button type="button" class="
                px-4
                py-2
                border border-gray-200
                text-[#000000]
                dark:text-gray-200
                mx-2
                rounded
              " @click="toggleUpdateAmountModal(null)">
                Đóng
              </button>
              <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded">
                Thêm mới
              </button>
            </div>
          </form>
        </div>
      </div>
      <h2 class="text-2xl font-bold">Lịch sử cập nhật</h2>
      <div class="w-full overflow-x-auto rounded-lg shadow-xs mb-4" v-dragscroll style="max-height: 400px;">
        <div class="w-full">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800 sticky top-0">
                <th class="px-4 py-3 font-bold">#</th>
                <th class="px-4 py-3">Lô</th>
                <th class="px-4 py-3">Số lượng</th>
                <th class="px-4 py-3">Ngày bắt đầu</th>
                <th class="px-4 py-3">Ngày kết thúc</th>
                <th class="px-4 py-3">Tạo bởi</th>
              </tr>
            </thead>
            <tbody class="bg-[#ffffff] divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr v-for="(produced, index) in this.idProduction.produced" :key="produced.id" class="text-gray-700 dark:text-gray-400">
                <th class="px-4 py-3">[[ ++index ]]</th>
                <th class="px-4 py-3">[[ produced.lot_number ]]</th>
                <th class="px-4 py-3">[[ produced.amount ]]</th>
                <th class="px-4 py-3">[[ new Date(produced.start_date).toLocaleDateString() ]]</th>
                <th class="px-4 py-3">[[ new Date(produced.end_date).toLocaleDateString() ]]</th>
                <th class="px-4 py-3">
                  <img v-tooltip.top-start="produced.user_create.name"
                  :src="'{{asset('/img/user')}}/' + produced.user_create.image"
                  class="h-12 w-12 object-cover object-center rounded-full" /></th>
                
              </tr>
            </tbody>
          </table>
          <div v-if="this.idProduction.produced.length == 0" class="text-sm text-center dark:text-gray-200 my-4">Không tìm thấy dữ liệu nào</div>
        </div>
      </div>
    </div>
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
            Xóa lệnh sản xuất
          </p>
          <!-- Modal description -->
          <p class="text-sm text-gray-700 dark:text-gray-400">
            Bạn có chắc chắn muốn xóa lệnh sản xuất này ?
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
            " @click="handleDelete('')">
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