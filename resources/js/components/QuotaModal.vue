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
        max-h-full
        overflow-y-auto
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
        <h2 class="text-2xl font-bold">Định mức ({{ this.product.Ten }})</h2>     
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
        <div class="text-base grow pl-2 flex flex-col">
          <form :action="'/admin/quota/create/' + product.id" method="post">     
            <input type="hidden" name="_token" :value="this.token">
            <PlanDetail/> 
          <div class="flex items-center justify-end text-sm">
            <button
              type="button"
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
              type="submit"
              class="px-4 py-2 bg-purple-600 text-white rounded"
            >
              Thêm ngay
            </button>
          </div>
          </form> 
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mixin as clickaway } from "vue-clickaway";
import PlanDetail from './PlanDetail.vue';
import "toastify-js/src/toastify.css";
export default {
  mixins: [clickaway],
  props: {
    product: Object,
  },
  components:{
    PlanDetail
  },
  data() {
    return {
      isOpenModal: false,
      isChange: false,
      token: document.querySelector("meta[name='csrf_token']").getAttribute("content")
    };
  },
  methods: {
    handleCloseModal() {
      this.$emit("toggle-profile", {
        isOpenModal: this.isOpenModal,
      });
    },
  },
};
</script>
<style scoped>
</style>