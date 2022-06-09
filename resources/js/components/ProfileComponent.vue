<template>
  <div
    class="w-full h-full fixed top-0 left-0 flex items-center backdrop-blur-lg"
  >
    <div
      class="
        profile__modal
        lg:w-2/5
        w-full
        h-fit
        flex flex-col
        bg-[#ffffff]
        mx-auto
        rounded-lg
        p-4
        z-50
        shadow
        dark:bg-gray-800 dark:text-gray-200
      "
      v-on-clickaway="handleCloseModal"
    >
      <div
        class="
          flex
          items-center
          justify-between
          border-bottom border-gray-200
          py-2
        "
      >
        <h2 class="text-2xl font-bold">Hồ sơ cá nhân</h2>
        <button
          class="rounded-lg border border-opacity-75"
          @click="handleCloseModal"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
      <div class="flex justify-between my-3">
        <label for="image" class="cursor-pointer h-fit rounded-full">
          <img
            :src="
              user.image != null
                ? !isChange
                  ? 'img/user/' + user.image
                  : user.image
                : !isChange
                ? 'img/user/user.png'
                : user.image
            "
            class="h-24 w-24 border rounded-full object-cover object-center"
            alt=""
          />
          <input
            id="image"
            type="file"
            class="hidden"
            @change="handleImageChange"
            accept="image/*"
          />
        </label>
        <div class="text-base grow pl-2 flex flex-col">
          <label class="mb-1">
            <span>Tên của bạn</span>
            <input
              class="
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
              "
              type="text"
              v-model="user.name"
            />
          </label>
          <label class="my-1">
            <span>Số điện thoại</span>
            <input
              class="
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
              "
              type="text"
              v-model="user.phone"
            />
          </label>
          <label class="my-1">
            <span>Email</span>
            <input
              class="
                block
                w-full
                mt-1
                text-sm
                dark:border-gray-600 dark:bg-gray-700
                focus:border-purple-400
                focus:outline-none
                focus:shadow-outline-purple
                dark:text-gray-300 dark:focus:shadow-outline-gray
                disabled:bg-gray-200
                dark:disabled:bg-gray-700
                form-input
              "
              type="text"
              disabled
              v-model="user.email"
            />
          </label>
          <p class="mt-2">Quyền: {{ user.role.name }} </p>
          <div class="flex items-center justify-end text-sm">
            <button
              class="
                px-4
                py-2
                border border-gray-200
                text-[#000000]
                dark:text-gray-200
                mx-2
                rounded
              "
              @click="handleCloseModal"
            >
              Đóng
            </button>
            <button
              class="px-4 py-2 bg-purple-600 text-white rounded"
              @click="handleUpdate"
            >
              Cập nhật
            </button>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-between bg-gray-200 rounded-lg p-2">
        <p class="text-sm text-[#000000] flex items-center">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 mr-1"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
              clip-rule="evenodd"
            />
          </svg>
          Nhấp vào ảnh để cập nhật ảnh của bạn
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import { mixin as clickaway } from "vue-clickaway";
import axios from "axios";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";
export default {
  mixins: [clickaway],
  props: {
    user: Object,
  },
  data() {
    return {
      isOpenModal: false,
      isChange: false,
    };
  },
  methods: {
    handleCloseModal() {
      this.$emit("toggle-profile", {
        isOpenModal: this.isOpenModal,
      });
    },
    async handleImageChange(e) {
      this.user.image = URL.createObjectURL(e.target.files[0]);
      this.isChange = true;
      let dataImage = new FormData();
      let config = {
        header: {
          "Content-Type": "image/*",
        },
      };
      dataImage.append("image", e.target.files[0]);
      await axios
        .post(`/admin/image-update/${this.user.id}`, dataImage, config)
        .catch((err) => console.log(err));
      Toastify({
        text: "Cập nhật ảnh thành công! Vui lòng tải lại trang",
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        className: "z-50",
        style: {
          background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () {}, // Callback after click
      }).showToast();
    },
    async handleUpdate() {
      let data = new FormData();
      let status = true;
      data.append("name", this.user.name);
      data.append("phone", this.user.phone);
      await axios
        .post(`/admin/update/${this.user.id}`, data)
        .then((res) => (this.user = res.data))
        .catch((err) => (status = false));

      const toast = Toastify({
        text: status
          ? "Cập nhật thành công! Vui lòng tải lại trang"
          : "Lỗi: Thông tin cập nhật không hợp lệ",
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        className: "z-50",
        style: {
          background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () {}, // Callback after click
      }).showToast();

      status && toast;
    }
  },
};
</script>
<style scoped>
</style>