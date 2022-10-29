<template>
  <div
    class="px-4 py-3 mb-8 bg-[#ffffff] rounded-lg shadow-md dark:bg-gray-800"
  >
    <div class="grid md:grid-cols-5 gap-4 items-center">
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400"
          >Mã xuất kho<span class="text-red-500">*</span></span
        >
        <input
          class="
            block
            w-full
            mt-1
            text-sm
            dark:border-gray-600 dark:bg-gray-700
            uppercase
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:text-gray-300 dark:focus:shadow-outline-gray
            form-input
          "
          placeholder="xkxxxxxx"
          name="code"
          v-model="productData.code"
        />
      </label>
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400"
          >Loại xuất kho <span class="text-red-500">*</span></span
        >
        <select
          class="
            block
            w-full
            mt-1
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
            mb-1
          "
          v-model="productData.type"
          name="type"
          id="type"
          aria-placeholder="Chọn loại xuất kho"
        >
          <option value="" disabled selected>-- Loại xuất kho --</option>
          <option value="1">Sản xuất</option>
          <option value="2">Bán hàng</option>
        </select>
      </label>
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400"
          >Sản phẩm<span class="text-red-500">*</span></span
        >
        <select
          class="
            block
            w-full
            mt-1
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
            mb-1
          "
          name="id_ingredient"
          id="id_ingredient"
          v-model="productData.id_ingredient"
          aria-placeholder="Chọn sản phẩm"
          @change="setPrice()"
        >
          <option value="">-- Chọn sản phẩm --</option>
          <option
            v-for="product in products"
            :key="product.id"
            :value="product.id"
          >
            {{ product.Ten }}
          </option>
        </select>
      </label>
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400"
          >Số lượng<span class="text-red-500">*</span></span
        >
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
          placeholder="Nhập số lượng"
          name="amount"
          v-model="productData.amount"
          type="number"
          min="1"
          value="1"
        />
      </label>
      <label class="block text-sm" v-if="productData.type == 2">
        <span class="text-gray-700 dark:text-gray-400"
          >Đơn hàng <span class="text-red-500">*</span></span
        >
        <select
          class="
            block
            w-full
            mt-1
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
            mb-1
          "
          name="id_order"
          id="id_order"
          v-model="productData.id_order"
          aria-placeholder="Chọn đơn hàng"
        >
          <option value="" disabled selected>-- Đơn hàng --</option>
          <option
            v-for="order in orders"
            v-if="order.detail.reduce((acc, item) => acc && item.id_product == productData.id_ingredient)"
            :key="order.id"
            :value="order.id"
          >
            {{ order.customer.name + " - " + order.customer.phone_number }}
          </option>
        </select>
      </label>    
      <label class="block text-sm max-w-xs" v-if="productData.type == 2">
        <span class="text-gray-700 dark:text-gray-400">Đã thanh toán</span>
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
          placeholder="Nhập số tiền đã thanh toán"
          name="paid"
          type="number"
          :min="(product_update && product_update.paid) || 0"
          :max="getPrice"
          v-model="productData.paid"
        />
      </label>
      <label v-if="productData.type == 1" class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400"
          >Lệnh sản xuất <span class="text-red-500">*</span></span
        >
        <select
          class="
            block
            w-full
            mt-1
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-select
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
            mb-1
          "
          name="id_production"
          id="id_production"
          v-model="productData.id_production"
          aria-placeholder="Chọn lệnh sản xuất"
        >
          <option value="" disabled selected>-- Lệnh sản xuất --</option>
          <option
            v-for="production in productions"
            :key="production.id"
            :value="production.id"
          >
            {{ production.code + " - " + production.product.Ten }}
          </option>
        </select>
      </label>
      <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400"
          >Ngày xuất kho<span class="text-red-500">*</span></span
        >
        <input
          class="
            block
            w-full
            mt-1
            text-sm
            dark:border-gray-600
            max-w-xs
            dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:text-gray-300 dark:focus:shadow-outline-gray
            form-input
          "
          placeholder="Ngày nhập kho"
          name="export_date"
          v-model="productData.export_date"
          type="date"
        />
      </label>
      <label class="block text-sm col-span-5">
        <span class="text-gray-700 dark:text-gray-400">Ghi chú</span>
        <textarea
          class="
            block
            w-full
            mt-1
            text-sm
            dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
            form-textarea
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:focus:shadow-outline-gray
          "
          rows="4"
          placeholder="Nhập ghi chú"
          name="note"
          v-model="productData.note"
        ></textarea>
      </label>
    </div>
    <div class="flex justify-end">
      <button
        class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 mx-2"
      >
        {{ this.product_update == null ? "Xuất kho" : "Cập nhật" }}
      </button>
      <a
        class="
          mt-4
          text-white
          px-4
          py-2
          rounded-md
          border-0
          bg-indigo-600
          cursor-pointer
        "
        @click.prevent="toggleModal"
        >Quay về</a
      >
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
        @click.prevent="toggleModal"
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
            @click.stop=""
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
                @click.prevent="toggleModal"
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
                Quay về
              </p>
              <!-- Modal description -->
              <p class="text-sm text-gray-700 dark:text-gray-400">
                Bạn có chắc chắn muốn quay về ?
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
                type="button"
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
                onclick="location.href='/admin/warehouse/exports'"
              >
                Chắc chắn
              </button>
              <button
                @click.prevent="toggleModal"
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
export default {
  props: {
    product_update: Object,
    products: Array,
    productions: Array,
    orders: Array,
    quick_code: String,
  },
  computed: {
    getPrice() {
      return this.productData.price * parseInt(this.productData.amount);
    },
  },
  mounted() {
    if (this.product_update != null) {
      this.productData = this.product_update;
    }
  },
  data() {
    return {
      isModalOpen: false,
      productData: {
        code: this.quick_code,
        type: 1,
        id_ingredient: 0,
        paid: 0,
        amount: 1,
        id_order: 0,
        id_production: 0,
        export_date: null,
        note: null,
        price: 0
      },
    };
  },
  methods: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    setPrice() {
      let product = this.products.find(
        (item) => item.id === this.productData.id_ingredient
      );

      this.productData.price = product != null ? product.GiaThanh : 0;
    }
  },
};
</script>