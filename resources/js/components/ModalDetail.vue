<template>
  <div
    class="
      z-50
      w-full
      h-full
      fixed
      backdrop-blur-sm
      flex
      items-center
      justify-center
      top-0
      left-0
      p-2
    "
  >
    <div
      class="
        bg-[#ffffff]
        dark:bg-gray-800
        z-10
        dark:text-gray-200
        lg:w-2/4
        w-full
        h-auto
        p-4
        shadow-md
        rounded-lg
        max-h-full
        overflow-auto
      "
    >
      <div class="flex items-center justify-between border-bottom">
        <h2 class="text-xl py-1">Chi tiết đơn hàng</h2>
        <span class="flex items-center">
          tạo bởi <strong class="ml-1">{{ this.order.user.name }}</strong>
          <img
            :src="'/img/user/' + this.order.user.image"
            class="h-7 w-7 rounded-full object-cover mx-1"
        /></span>
      </div>
      <div class="w-full border-bottom py-2 flex flex-col">
        <span class="w-100"
          >Tên khách hàng: {{ this.order.customer.name }}</span
        >
        <span class="w-100"
          >Số điện thoại: {{ this.order.customer.phone_number }}</span
        >
        <span class="w-100">Địa chỉ: {{ this.order.customer.address }}</span>
      </div>
      <div class="w-full border-bottom py-2 flex flex-col">
        <h3 class="font-bold">Thông tin đơn hàng</h3>
        <div class="grid grid-cols-6 gap-x-1 gap-y-2 my-3 items-center">
          <span>Hình ảnh</span>
          <span class="col-span-2">Tên sản phẩm - Số lượng</span>
          <span class="text-center">Chất lượng</span>
          <span class="text-center">Đơn giá</span>
          <span class="text-center">Tổng tiền</span>
        </div>
        <div
          class="grid grid-cols-6 gap-x-1 gap-y-2 my-3 items-center px-2 py-1 rounded-md hover:bg-gray-50 hover:text-gray-700 hover:font-bold cursor-pointer ease-in duration-150"
          v-for="detail in this.order.detail"
          :key="detail.id"
        >
          <img
            :src="'img/' + detail.image"
            class="
              product__thumbnail
              h-16
              max-w-max
              object-contain
              rounded-lg
              z-50
              my-1
            "
            loading="lazy"
          />
          <span class="col-span-2"
            >{{ detail.product.Ten }} x {{ detail.amount }}
            {{ detail.product.unit_cal.name }}</span
          >
          <span class="text-center">{{
            detail.quality && detail.quality.Ten
          }}</span>
          <span class="text-center">{{
            detail.product && detail.price.toLocaleString()
          }}</span>
          <span class="text-center">{{
            Number(detail.amount * detail.price).toLocaleString()
          }}</span>
        </div>
        <span class="py-2 border-top">Ghi chú: {{ this.order.note }}</span>
        <h3 class="font-bold text-base dark:text-gray-200">
          Thông tin thanh toán
        </h3>
        <ul>
          <li class="flex justify-between">
            Tổng thành tiền:
            <span class="font-bold text-base text-green-500">{{
              this.formatPrice(this.order.total)
            }}</span>
          </li>
          <li class="flex justify-between">
            Đã thanh toán:
            <span class="font-bold text-base text-green-500">{{
              this.formatPrice(this.order.paid)
            }}</span>
          </li>
          <li class="flex justify-between">
            Còn lại:
            <span class="font-bold text-base text-red-500">{{
              this.formatPrice(this.order.total - this.order.paid)
            }}</span>
          </li>
        </ul>
      </div>
      <div class="flex items-center justify-between">
        <span class="text-base flex items-center">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 mr-1"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          Hạn giao:
          <span
            class="mx-2"
            :class="{ 'text-red-500 font-bold': expireTime <= 2 }"
          >
            {{ expireTime > 0 ? `Còn ${expireTime} ngày` : "Hết hạn" }}
          </span></span
        >
        <button
          class="
            px-3
            py-2
            bg-indigo-500
            hover:bg-indigo-600
            duration-150
            ease-in
            text-white
            rounded-lg
            mt-2
          "
          @click="closeModal"
        >
          Đóng
        </button>
      </div>
    </div>
    <div
      class="w-full h-full absolute left-0 top-0 bg-gray-800 opacity-50 z-0"
      @click="closeModal"
    ></div>
  </div>
</template>
<script>
import mediumZoom from "medium-zoom";

export default {
  props: {
    order: Object,
  },
  mounted() {
    mediumZoom(document.querySelectorAll(".product__thumbnail"), {
      background: "rgba(0,0,0,0)",
    });
  },
  data() {
    return {
      isOpen: false,
    };
  },
  computed: {
    expireTime() {
      const now = Date.now();
      const expire = this.order.NgayTraDon && new Date(this.order.NgayTraDon);
      const result = expire - now;
      return Math.ceil(result / (1000 * 60 * 60 * 24));
    },
  },
  methods: {
    closeModal() {
      this.isOpen = false;
      this.$emit("toggle-detail", {
        isOpen: this.isOpen,
      });
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        .concat("đ");
    }
  },
};
</script>
<style scoped>
</style>