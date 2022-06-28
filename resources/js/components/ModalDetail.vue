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
        <span class="w-100">Tên khách hàng: {{ this.order.TenKhachHang }}</span>
        <span class="w-100">Số điện thoại: {{ this.order.SoDienThoai }}</span>
        <span class="w-100">Địa chỉ: {{ this.order.DiaChi }}</span>
      </div>
      <div class="w-full border-bottom py-2 flex flex-col">
        <h3 class="font-bold">Thông tin đơn hàng</h3>
        <img
          :src="'img/' + this.order.detail.image"
          class="
            product__thumbnail
            h-36
            max-w-max
            object-contain
            rounded-lg
            z-50
            my-1
          "
          loading="lazy"
        />
        <span>Tên sản phẩm: {{ this.order.detail.TenSP }}</span>
        <span>Loại hàng: {{ this.order.detail.LoaiHang }}</span>
        <span
          >Danh mục:
          {{
            this.order.detail.category && this.order.detail.category.Ten
          }}</span
        >
        <span
          >Chất lượng:
          {{ this.order.detail.quality && this.order.detail.quality.Ten }}</span
        >
        <span
          >Vải chính:
          {{
            this.order.detail.fabric_main && this.order.detail.fabric_main.Ten
          }}
          - {{ this.order.detail.fabric_detail.VaiChinh }}m</span
        >
        <span
          ><p v-if="this.order.detail.fabric_extra">
            Vải phụ:
            {{
              this.order.detail.fabric_extra &&
              this.order.detail.fabric_extra.Ten
            }}
            - {{ this.order.detail.fabric_detail.VaiPhu }}m
          </p></span
        >
        <span>
          <p v-if="this.order.detail.fabric_lining">
            Vải lót:
            {{
              this.order.detail.fabric_lining &&
              this.order.detail.fabric_lining.Ten
            }}
            - {{ this.order.detail.fabric_detail.VaiLot }}m
          </p></span
        >

        <span class="font-bold text-base">Phụ liệu</span>
        <span
          v-for="(ingredient, index) in this.order.detail.ingredient_details"
          :key="ingredient.id"
        >
          <div>
            {{ ++index }}.
            {{ ingredient.ingredient && ingredient.ingredient.Ten }} - Số lượng:
            {{ ingredient.ingredient && ingredient.SoLuong }} cái
          </div>
        </span>
        <h3 class="font-bold mt-2">Phân loại thuộc tính</h3>
        <div
          v-for="(properties, index) in this.order.detail.properties"
          :key="properties.id"
          class="flex items-center justify-between py-2"
        >
          <span>SP{{ index + 1 }}</span>
          <span class="mx-1">Cân nặng: {{ properties.CanNang }}Kg</span>
          <span class="mx-1">Chiều cao: {{ properties.ChieuCao }}cm</span>
          <span class="mx-1">Kích cỡ: {{ properties.KichCo }}</span>
          <span class="mx-1">Số lượng: {{ properties.SoLuong }} cái</span>
        </div>
        <span class="py-2 border-top"
          >Ghi chú: {{ this.order.detail.GhiChu }}</span
        >
        <h3 class="font-bold text-base dark:text-gray-200">Thanh toán</h3>
        <ul>
          <li>
            Tổng thành tiền:
            <span class="font-bold text-base text-green-500">{{
              this.formatPrice(this.order.TongTien)
            }}</span>
          </li>
          <li>
            Đã thanh toán:
            <span class="font-bold text-base text-green-500">{{
              this.formatPrice(this.order.detail.TienCoc)
            }} <small class="text-[#000000] dark:text-gray-200">(Tiền cọc) +</small> {{ this.formatPrice(this.order.detail.ThanhToanBS) }} <small class="text-[#000000] dark:text-gray-200">(Thanh toán bổ sung)</small></span>
          </li>
          <li>
            Còn lại:
            <span class="font-bold text-base text-red-500">{{
              this.formatPrice(this.order.TongTien - this.order.detail.TienCoc)
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
          class="p-2 bg-indigo-600 text-white rounded-lg mt-2"
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
    mediumZoom(document.querySelector(".product__thumbnail"), {
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
      const result = Math.abs(expire - now);
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
    },
  },
};
</script>
<style scoped>
</style>