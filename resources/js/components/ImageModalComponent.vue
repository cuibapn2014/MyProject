<template>
  <div>
    <div class="w-16 h-16 relative mx-2" :key="this.data.id">
      <img
        class="w-full h-full object-cover rounded-lg"
        :src="'img/' + this.data.urlImage"
      />
      <span class="absolute top-0 right-0 cursor-pointer" title="Xóa ảnh">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 text-gray-50"
          viewBox="0 0 20 20"
          fill="currentColor"
          @click="openModal"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd"
          />
        </svg>
      </span>
    </div>

    <transition
      enter-class="ease-out opacity-0"
      enter-to-class="opacity-100"
      leave-class="ease-in opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-show="this.isModalOpen"
        class="
          fixed
          inset-0
          z-30
          flex
          items-end
          transition
          duration-150
          bg-black bg-opacity-50
          sm:items-center sm:justify-center
        "
        id="backdrop-overlay"
        @click="handleClickBackDrop"
      >
        <transition
          enter-class="ease-out opacity-0 transform translate-y-1/2"
          enter-to-class="opacity-100"
          leave-class="ease-in opacity-100"
          leave-to-class="opacity-0 transform translate-y-1/2"
        >
          <!-- Modal -->
          <div
            v-show="this.isModalOpen"
            class="
              w-full
              px-6
              py-4
              overflow-hidden
              bg-[#ffffff]
              rounded-t-lg
              duration-150
              dark:bg-gray-800
              sm:rounded-lg sm:m-4 sm:max-w-xl
            "
            role="dialog"
            id="modal"
          >
            <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
            <header class="flex justify-end">
              <button
                class="
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
                "
                aria-label="close"
                @click="closeModal"
              >
                <svg
                  class="w-4 h-4"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  role="img"
                  aria-hidden="true"
                >
                  <path
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                    fill-rule="evenodd"
                  ></path>
                </svg>
              </button>
            </header>
            <!-- Modal body -->
            <div class="mt-4 mb-6">
              <!-- Modal title -->
              <p
                class="
                  mb-2
                  text-lg
                  font-semibold
                  text-gray-700
                  dark:text-gray-300
                "
              >
                Xóa ảnh
              </p>
              <!-- Modal description -->
              <p class="text-sm text-gray-700 dark:text-gray-400">
                Bạn có chắc chắn muốn xóa ảnh này ?
              </p>
            </div>
            <footer
              class="
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
              "
            >
              <button
                @click="this.handleDeleteImage"
                class="
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
                "
              >
                Chắc chắn
              </button>
              <button
                @click.prevent="closeModal"
                class="
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
                "
              >
                Hủy bỏ
              </button>
            </footer>
          </div>
        </transition>
      </div>
    </transition>
  </div>
</template>
<script>
import { mixin as clickaway } from "vue-clickaway";
export default {
  mixins: [clickaway],
  props: {
    data: Object,
  },
  data() {
    return {
      isModalOpen: false,
    };
  },
  methods: {
    openModal() {
      this.isModalOpen = true;
    },

    closeModal() {
      this.isModalOpen = false;
    },
    handleDeleteImage() {
      location.href = `/admin/image/delete/${this.data.type}/${this.data.id_provide}/${this.data.id}`;
    },
    handleClickBackDrop(e) {
      if (e.target == document.querySelector("#backdrop-overlay"))
        this.closeModal();
    },
  },
};
</script>
<style scoped>
</style>