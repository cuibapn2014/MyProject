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
      <h2 class="text-xl border-bottom py-1">Chi tiết đơn hàng</h2>
      <div class="w-full border-bottom py-2 flex flex-col">
        <span class="w-100">Tên khách hàng: {{ this.order.TenKhachHang }}</span>
        <span class="w-100">Số điện thoại: {{ this.order.SoDienThoai }}</span>
        <span class="w-100">Địa chỉ: {{ this.order.DiaChi }}</span>
      </div>
      <div class="w-full border-bottom py-2 flex flex-col">
        <h3 class="font-bold">Thông tin đơn hàng</h3>
        <img
          :src="'img/' + this.order.detail.image"
          class="product__thumbnail h-16 w-16 object-cover rounded-lg z-50 my-1"
          loading="lazy"
        />
        <span>Tên sản phẩm: {{ this.order.detail.TenSP }}</span>
        <span>Loại hàng: {{ this.order.detail.LoaiHang }}</span>
        <span>Danh mục: {{ this.order.detail.category.Ten }}</span>
        <span>Chất lượng: {{ this.order.detail.quality.Ten }}</span>
        <span>Loại vải: {{ this.order.detail.fabric.Ten }}</span>
        <span>Vải chính: {{ this.order.detail.VaiChinh }}m</span>
        <span>Vải phụ: {{ this.order.detail.VaiPhu }}m</span>
        <span>Vải lót: {{ this.order.detail.VaiLot }}m</span>
        <span>Phụ liệu: {{ this.order.detail.ingredient.Ten }}</span>
        <span>Ghi chú: {{ this.order.detail.GhiChu }}</span>
        <h3 class="font-bold mt-2">Phân loại thuộc tính</h3>
        <div
          v-for="(properties, index) in this.order.detail.properties"
          :key="properties.id"
          class="flex items-center justify-between"
        >
          <span>SP{{ index + 1 }}</span>
          <span class="mx-1">Cân nặng: {{ properties.CanNang }}Kg</span>
          <span class="mx-1">Chiều cao: {{ properties.ChieuCao }}cm</span>
          <span class="mx-1">Kích cỡ: {{ properties.KichCo }}</span>
          <span class="mx-1">Số lượng: {{ properties.SoLuong }} cái</span>
        </div>
      </div>
      <button
        class="p-2 bg-indigo-600 text-white rounded-lg mt-2 float-right"
        @click="closeModal"
      >
        Đóng
      </button>
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
    mediumZoom(document.querySelector(".product__thumbnail"));
  },
  data() {
    return {
      isOpen: false,
    };
  },
  methods: {
    closeModal() {
      this.isOpen = false;
      this.$emit("toggle-detail", {
        isOpen: this.isOpen,
      });
    },
  },
};
</script>
<style scoped>
</style>