<template>
  <div
    class="px-4 py-3 mb-8 bg-[#ffffff] rounded-lg shadow-md dark:bg-gray-800"
  >
    <h3 class="mb-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Thông tin khách hàng
    </h3>
    <label class="block text-sm my-1">
      <span class="flex text-gray-700 dark:text-gray-400"
        >Tên khách hàng
        <p class="text-red-500 mx-1">*</p></span
      >
      <input
        class="
          block
          w-full
          mt-1
          text-sm
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        "
        placeholder="Nguyễn Văn A"
        name="fullname"
        v-model="user.customer"
        autocomplete="off"
      />
    </label>

    <label class="block text-sm my-1">
      <span class="flex text-gray-700 dark:text-gray-400"
        >Số điện thoại
        <p class="text-red-500 mx-1">*</p></span
      >
      <input
        class="
          block
          w-full
          mt-1
          text-sm
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        "
        placeholder="XXXXXXXXXX"
        name="phone_number"
        type="text"
        v-model="user.phone"
      />
    </label>

    <div class="flex flex-row sm:flex-col items-center justify-start">
      <label class="block mt-4 text-sm sm:w-full">
        <span class="flex text-gray-700 dark:text-gray-400">
          Tỉnh/Thành Phố
          <p class="text-red-500 mx-1">*</p></span
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
          "
          @change="handleChangeProvince"
          name="province"
        >
          <option selected value="">Chọn Tỉnh/Thành phố</option>
          <option
            v-for="province in this.dataProvince"
            :key="province.code"
            :value="province.name"
            :selected="oldprovince != null && province.name == oldprovince"
          >
            {{ province.name }}
          </option>
        </select>
      </label>
      <label class="block mt-4 text-sm mx-2 sm:w-full">
        <span class="flex text-gray-700 dark:text-gray-400">
          Quận/Huyện
          <p class="text-red-500 mx-1">*</p></span
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
          "
          @change="handleChangeDistrict"
          name="district"
        >
          <option selected value="">Chọn Quận/Huyện</option>
          <option v-if="olddistrict != ''" selected :value="olddistrict">
            {{ olddistrict }}
          </option>
          <option
            v-for="district in this.dataDistrict"
            :key="district.code"
            :value="district.name"
          >
            {{ district.name }}
          </option>
        </select>
      </label>

      <label class="block mt-4 text-sm mx-2 sm:w-full">
        <span class="flex text-gray-700 dark:text-gray-400">
          Phường/Xã
          <p class="text-red-500 mx-1">*</p></span
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
          "
          name="ward"
        >
          <option selected value="">Chọn Phường/Xã</option>
          <option v-if="oldward != ''" selected :value="oldward">
            {{ oldward }}
          </option>
          <option
            v-for="ward in this.dataWard"
            :key="ward.code"
            :value="ward.name"
            :selected="oldward != null && ward.name == oldward"
          >
            {{ ward.name }}
          </option>
        </select>
      </label>
    </div>
    <label class="block text-sm my-1">
      <span class="flex text-gray-700 dark:text-gray-400"
        >Địa chỉ
        <p class="text-red-500 mx-1">*</p></span
      >
      <input
        class="
          block
          w-full
          mt-1
          text-sm
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        "
        placeholder="Tên đường, Hẻm/ngõ.."
        name="address"
        type="text"
        v-model="user.address"
      />
    </label>

    <h3 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Thông tin đơn hàng
    </h3>
    <div class="mt-4 text-sm">
      <span class="text-gray-700 dark:text-gray-400"> Loại hàng </span>
      <div class="mt-2">
        <label
          class="inline-flex items-center text-gray-600 dark:text-gray-400"
        >
          <input
            type="radio"
            class="
              text-purple-600
              form-radio
              focus:border-purple-400
              focus:outline-none
              focus:shadow-outline-purple
              dark:focus:shadow-outline-gray
            "
            name="productType"
            value="available"
            @change="handleChecked"
            checked
          />
          <span class="ml-2">Hàng may</span>
        </label>
        <label
          class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400"
        >
          <input
            type="radio"
            class="
              text-purple-600
              form-radio
              focus:border-purple-400
              focus:outline-none
              focus:shadow-outline-purple
              dark:focus:shadow-outline-gray
            "
            name="productType"
            value="unavailable"
            @change="handleChecked"
          />
          <span class="ml-2">Hàng mẫu</span>
        </label>
      </div>
    </div>
    <div class="flex items-end">
      <label class="block text-sm mr-2 grow">
        <span class="flex text-gray-700 dark:text-gray-400"
          >Tên sản phẩm
          <p class="text-red-500 mx-1">*</p></span
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
          placeholder=""
          name="product_name"
        />
      </label>
      <label v-if="this.productType === 'unavailable'">
        <span class="dark:text-gray-200 flex"
          >Giá
          <p class="text-red-500 mx-1">*</p></span
        >
        <div class="relative text-gray-500 focus-within:text-purple-600">
          <input
            class="
              block
              w-full
              pr-20
              text-sm text-[#000000]
              dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
              focus:border-purple-400
              focus:outline-none
              focus:shadow-outline-purple
              dark:focus:shadow-outline-gray
              form-input
              dark:text-gray-200
            "
            placeholder=""
            min="0"
            type="number"
            v-model="price"
            name="price"
            autocomplete="off"
          />
          <p
            class="
              absolute
              inset-y-0
              right-0
              px-4
              text-sm
              font-medium
              leading-5
              text-white
              transition-colors
              duration-150
              bg-indigo-600
              rounded-r-md
              focus:outline-none focus:shadow-outline-purple
              flex
              items-center
            "
          >
            VND
          </p>
        </div>
      </label>
    </div>
    <label class="block my-2 text-sm w-2/4 sm:w-full">
      <span class="flex text-gray-700 dark:text-gray-400">
        Danh mục sản phẩm
        <p class="text-red-500 mx-1">*</p></span
      >
      <select
        class="
          block
          w-full
          mt-1
          text-sm
          dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
          form-select
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:focus:shadow-outline-gray
        "
        name="category"
        @change="handleChangeCategory"
      >
        <option selected :value="null">Chọn danh mục</option>
        <option
          v-for="category in this.dataCategory"
          :key="category.id"
          :value="category.id"
        >
          {{ category.Ten }}
        </option>
      </select>
    </label>
    <div class="upload__image block text-sm my-3">
      <label class="text-gray-700 dark:text-gray-400">Hình ảnh</label>
      <InputFile />
    </div>
    <h3 class="mt-4 font-bold text-lg dark:text-gray-200">
      Thuộc tính sản phẩm
    </h3>
    <div class="flex flex-col">
      <div
        class="flex items-center"
        v-for="(properties, index) in dataProperty"
        :key="index"
      >
        <label class="block text-sm mr-2">
          <span class="flex text-gray-700 dark:text-gray-400"
            >Cân nặng (Kg)
          </span>
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
            type="number"
            placeholder=""
            name="weight[]"
          />
        </label>
        <label class="block text-sm mr-2">
          <span class="flex text-gray-700 dark:text-gray-400"
            >Chiều cao (cm)
          </span>
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
            type="number"
            placeholder=""
            name="height[]"
          />
        </label>
        <label class="block text-sm my-1 mx-2">
          <span class="flex text-gray-700 dark:text-gray-400">Size</span>
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
            "
            name="size[]"
          >
            <option selected value=""></option>
            <option v-for="size in dataSize" :key="size" :value="size">
              {{ size }}
            </option>
          </select>
        </label>
        <label class="block text-sm my-1 mx-2">
          <span class="flex text-gray-700 dark:text-gray-400"
            >Số lượng
            <p class="text-red-500 mx-1">*</p></span
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
            type="number"
            min="1"
            placeholder=""
            name="quantity[]"
            v-model="properties.quantity"
          />
        </label>
      </div>
    </div>
    <button
      class="px-2 py-2 rounded-md text-sm text-white bg-indigo-600"
      @click.prevent="handleClickAddProperty"
    >
      Thêm thuộc tính
    </button>
    <button
      class="px-2 py-2 rounded-md text-sm text-white bg-indigo-600"
      @click.prevent="handleClickRemoveProperty"
    >
      Xóa
    </button>
    <label class="block my-2 text-sm w-2/4 sm:w-full">
      <span class="flex text-gray-700 dark:text-gray-400">
        Chất lượng hàng
        <p class="text-red-500 mx-1">*</p></span
      >
      <select
        class="
          block
          w-full
          mt-1
          text-sm
          dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
          form-select
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:focus:shadow-outline-gray
        "
        name="quality"
        @change="handleChangeQuality"
      >
        <option selected value="">Chọn chất lượng</option>
        <option
          v-for="quality in this.dataQuality"
          :key="quality.id"
          :value="quality.id"
        >
          {{ quality.Ten }}
        </option>
      </select>
    </label>
    <div
      class="flex mt-1 items-center justify-start"
      v-show="productType == 'available'"
    >
      <label>
        <span class="dark:text-gray-200 flex font-bold"
          >Giá/Sản phẩm
          <p class="text-red-500 mx-1">*</p></span
        >
        <div class="relative text-gray-500 focus-within:text-purple-600">
          <input
            class="
              block
              w-full
              pr-20
              text-base
              font-bold
              text-[#000000]
              dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
              focus:border-purple-400
              focus:outline-none
              focus:shadow-outline-purple
              dark:focus:shadow-outline-gray
              form-input
              dark:text-gray-200
            "
            placeholder=""
            min="0"
            type="number"
            name="price"
            v-model="price"
            autocomplete="off"
          />
          <p
            class="
              absolute
              inset-y-0
              right-0
              px-4
              text-sm
              font-medium
              leading-5
              text-white
              transition-colors
              duration-150
              bg-indigo-600
              rounded-r-md
              focus:outline-none focus:shadow-outline-purple
              flex
              items-center
            "
          >
            VND
          </p>
        </div>
      </label>
      <label class="block text-sm my-1 mx-2">
        <span class="flex text-gray-700 dark:text-gray-200 font-bold"
          >Tổng tiền gia công
          <p class="text-red-500 mx-1">*</p></span
        >
        <input
          class="
            block
            w-full
            mt-1
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            text-base
            font-bold
            focus:shadow-outline-purple
            text-green-500 dark:focus:shadow-outline-gray
            form-input
            focus:dark:bg-green-500
            focus:bg-green-500
            hover:dark:bg-green-500
            hover:bg-green-500
            focus:text-white
            hover:text-white
            duration-150 ease-in
          "
          type="number"
          min="0"
          name="total"
          placeholder=""
          :value="sum"
        />
      </label>
    </div>
    <h3 class="font-bold dark:text-gray-200 text-lg">Chọn vải cho sản phẩm</h3>
    <div class="flex items-center">
      <label class="block my-1 text-sm w-2/4 sm:w-full mr-2">
        <span class="flex text-gray-700 dark:text-gray-400">
          Vải chính
          <p class="text-red-500 mx-1">*</p></span
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
          "
          name="fabric_main"
          @change="this.handleChangeMain"
        >
          <option selected value="">Chọn loại vải chính</option>
          <option
            v-for="fabric in this.dataFabric"
            :key="fabric.id"
            :value="fabric.id"
          >
            {{
              fabric.Ten +
              " - " +
              fabric.Gia.toLocaleString("vi-VN", {
                style: "currency",
                currency: "VND",
              })
            }}
          </option>
        </select>
      </label>
      <label class="block text-sm mr-2">
        <span class="flex text-gray-700 dark:text-gray-400"
          >Chiều dài (Mét)</span
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
          placeholder=""
          name="main"
          type="number"
          min="0"
          v-model="fabricMain.quantity"
        />
      </label>
      <label class="block text-sm my-1 mx-2">
        <span class="flex text-gray-700 dark:text-gray-400">Thành tiền</span>
        <input
          class="
            block
            w-full
            mt-1
            text-sm
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:text-gray-300 dark:focus:shadow-outline-gray
            disabled:bg-gray-50
            form-input
          "
          type="text"
          min="0"
          placeholder=""
          value="0"
          readonly
          :value="this.formatPrice(this.totalMain)"
          :disabled="true"
        />
      </label>
    </div>
    <div class="flex items-center">
      <label class="block my-1 text-sm w-2/4 sm:w-full mr-2">
        <span class="flex text-gray-700 dark:text-gray-400">
          Vải phụ
          <p class="text-red-500 mx-1">*</p></span
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
          "
          name="fabric_extra"
          @change="this.handleChangeExtra"
        >
          <option selected value="">Chọn loại vải phụ</option>
          <option
            v-for="fabric in this.dataFabric"
            :key="fabric.id"
            :value="fabric.id"
          >
            {{
              fabric.Ten +
              " - " +
              fabric.Gia.toLocaleString("vi-VN", {
                style: "currency",
                currency: "VND",
              })
            }}
          </option>
        </select>
      </label>
      <label class="block text-sm mr-2">
        <span class="flex text-gray-700 dark:text-gray-400"
          >Chiều dài (Mét)
        </span>
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
          placeholder=""
          name="extra"
          type="number"
          min="0"
          v-model="fabricExtra.quantity"
        />
      </label>
      <label class="block text-sm my-1 mx-2">
        <span class="flex text-gray-700 dark:text-gray-400">Thành tiền</span>
        <input
          class="
            block
            w-full
            mt-1
            text-sm
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:text-gray-300 dark:focus:shadow-outline-gray
            disabled:bg-gray-50
            form-input
          "
          type="text"
          min="0"
          placeholder=""
          value="0"
          readonly
          :value="this.formatPrice(this.totalExtra)"
          :disabled="true"
        />
      </label>
    </div>
    <div class="flex items-center">
      <label class="block my-1 text-sm w-2/4 sm:w-full mr-2">
        <span class="flex text-gray-700 dark:text-gray-400">
          Vải lót
          <p class="text-red-500 mx-1">*</p></span
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
          "
          name="fabric_lining"
          @change="this.handleChangeLining"
        >
          <option selected value="">Chọn loại vải lót</option>
          <option
            v-for="fabric in this.dataFabric"
            :key="fabric.id"
            :value="fabric.id"
          >
            {{
              fabric.Ten +
              " - " +
              fabric.Gia.toLocaleString("vi-VN", {
                style: "currency",
                currency: "VND",
              })
            }}
          </option>
        </select>
      </label>
      <label class="block text-sm mr-2">
        <span class="flex text-gray-700 dark:text-gray-400"
          >Chiều dài (Mét)
        </span>
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
          placeholder=""
          name="lining"
          type="number"
          min="0"
          v-model="fabricLining.quantity"
        />
      </label>
      <label class="block text-sm my-1 mx-2">
        <span class="flex text-gray-700 dark:text-gray-400">Thành tiền</span>
        <input
          class="
            block
            w-full
            mt-1
            text-sm
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:text-gray-300 dark:focus:shadow-outline-gray
            disabled:bg-gray-50
            form-input
          "
          type="text"
          min="0"
          placeholder=""
          value="0"
          readonly
          :value="this.formatPrice(this.totalLining)"
          :disabled="true"
        />
      </label>
    </div>

    <label class="block text-sm my-1">
      <span class="flex text-gray-700 dark:text-gray-400 font-bold"
        >Tổng tiền vải
      </span>
      <input
        class="
            block
            w-full
            mt-1
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            text-base
            font-bold
            cursor-pointer
            focus:shadow-outline-purple
            text-green-500 dark:focus:shadow-outline-gray
            form-input
            focus:dark:bg-green-500
            focus:bg-green-500
            hover:dark:bg-green-500
            hover:bg-green-500
            focus:text-white
            hover:text-white
            duration-150 ease-in
            text-end
          "
        type="text"
        min="0"
        readonly
        :value="
          this.formatPrice(this.totalMain + this.totalExtra + this.totalLining)
        "
        placeholder=""
      />
    </label>
    <!-- <label class="block my-2 text-sm w-2/4 sm:w-full">
      <span class="flex text-gray-700 dark:text-gray-400">
        Nguồn cung cấp vải
        <p class="text-red-500 mx-1">*</p></span
      >
      <select
        class="
          block
          w-full
          mt-1
          text-sm
          dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
          form-select
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:focus:shadow-outline-gray
        "
        name="fabric_owner"
      >
        <option selected value="">Chọn nguồn cung cấp</option>
        <option
          value="company"
        >
          Công ty
        </option>
        <option
          value="customer"
        >
          Khách hàng
        </option>
      </select>
    </label> -->
    <h3 class="font-bold dark:text-gray-200 text-base">Chọn phụ liệu</h3>
    <div
      class="flex items-center"
      v-for="(item, index) in this.listIngredient"
      :key="index"
    >
      <label class="block my-2 text-sm w-2/4 sm:w-full">
        <span class="flex text-gray-700 dark:text-gray-400"> Phụ liệu </span>
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
          "
          @change="handleChangeIngredient($event, index)"
          name="ingredient[]"
          v-model="item.ingredient"
        >
          <option selected value="">Chọn phụ liệu</option>
          <option
            v-for="ingredient in dataIngredient"
            :key="ingredient.id"
            :value="ingredient.id"
          >
            {{ ingredient.Ten }}
          </option>
        </select>
      </label>
      <label class="block text-sm my-1 mx-2">
        <span class="flex text-gray-700 dark:text-gray-400"
          >Số lượng
          <p class="text-red-500 mx-1">*</p></span
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
          type="number"
          min="1"
          placeholder=""
          name="ingredient_quantity[]"
          v-model="item.quantity"
        />
      </label>
      <label class="block text-sm my-1 mx-2">
        <span class="flex text-gray-700 dark:text-gray-400">Thành tiền</span>
        <input
          class="
            block
            w-full
            mt-1
            text-sm
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            focus:shadow-outline-purple
            dark:text-gray-300 dark:focus:shadow-outline-gray
            disabled:bg-gray-50
            form-input
          "
          type="text"
          min="0"
          placeholder=""
          value="0"
          readonly
          :value="formatPrice(item.quantity * item.price)"
          :disabled="true"
        />
      </label>
    </div>
    <button
      class="p-2 bg-indigo-600 text-white my-2 rounded-lg"
      @click.prevent="handleClickAddIngredient"
    >
      Thêm phụ liệu
    </button>
    <button
      class="p-2 bg-indigo-600 text-white my-2 rounded-lg"
      @click.prevent="handleClickRemoveIngredient"
    >
      Xóa phụ liệu
    </button>
    <label class="block text-sm my-1">
      <span class="flex text-gray-700 dark:text-gray-400 font-bold"
        >Tổng tiền phụ liệu
      </span>
      <input
        class="
            block
            w-full
            mt-1
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            text-base
            font-bold
            cursor-pointer
            focus:shadow-outline-purple
            text-green-500 dark:focus:shadow-outline-gray
            form-input
            focus:dark:bg-green-500
            focus:bg-green-500
            hover:dark:bg-green-500
            hover:bg-green-500
            focus:text-white
            hover:text-white
            duration-150 ease-in
            text-end
          "
        type="text"
        min="0"
        readonly
        :value="this.formatPrice(this.totalPriceIngredient)"
        placeholder=""
      />
    </label>
    <label class="block text-sm my-1">
      <span class="flex text-gray-700 dark:text-gray-400"
        >Tiền cọc
        <p class="text-red-500 mx-1">*</p></span
      >
      <input
        class="
          block
          w-full
          mt-1
          text-sm
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        "
        type="number"
        min="0"
        placeholder=""
        name="deposit"
        v-model="deposit"
        :max="this.total"
      />
    </label>
    <label class="block text-sm my-1">
      <span class="flex text-gray-700 dark:text-gray-400 font-bold"
        >Tổng thành tiền
      </span>
      <input
        class="
            block
            w-full
            mt-1
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            text-base
            font-bold
            cursor-pointer
            focus:shadow-outline-purple
            text-green-500 dark:focus:shadow-outline-gray
            form-input
            focus:dark:bg-green-500
            focus:bg-green-500
            hover:dark:bg-green-500
            hover:bg-green-500
            focus:text-white
            hover:text-white
            duration-150 ease-in
            text-end
          "
        type="number"
        min="0"
        readonly
        name="totalPrice"
        placeholder=""
        :value="this.total + this.totalPriceIngredient"
      />
    </label>
    <label class="block text-sm my-1">
      <span class="flex text-gray-700 dark:text-gray-400">Tiền còn lại </span>
      <input
        class="
            block
            w-full
            mt-1
            bg-gray-50
            dark:border-gray-600 dark:bg-gray-700
            focus:border-purple-400
            focus:outline-none
            text-base
            font-bold
            focus:shadow-outline-purple
            text-red-500 dark:focus:shadow-outline-gray
            form-input
            cursor-pointer
            focus:dark:bg-red-500
            focus:bg-red-500
            hover:dark:bg-red-500
            hover:bg-red-500
            focus:text-white
            hover:text-white
            duration-150 ease-in
            text-end
          "
        type="text"
        placeholder=""
        :value="
          this.formatPrice(
            this.total + this.totalPriceIngredient - this.deposit
          )
        "
        disabled
      />
    </label>
    <label class="block text-sm my-1 lg:w-1/4">
      <span class="flex text-gray-700 dark:text-gray-400">Ngày trả đơn </span>
      <input
        class="
          block
          w-full
          mt-1
          text-sm
          disabled:bg-gray-50
          dark:border-gray-600 dark:bg-gray-700
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:text-gray-300 dark:focus:shadow-outline-gray
          form-input
        "
        type="date"
        name="duration"
        placeholder=""
      />
    </label>
    <label class="block mt-4 text-sm">
      <span class="text-gray-700 dark:text-gray-400">Yêu cầu khách hàng</span>
      <textarea
        class="
          block
          w-full
          mt-1
          text-sm
          dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700
          form-textarea
          focus:border-purple-400 focus:outline-none focus:shadow-outline-purple
          dark:focus:shadow-outline-gray
        "
        rows="3"
        :value="note"
        placeholder=""
        name="note"
      ></textarea>
    </label>
    <div class="flex justify-end">
      <button
        class="mt-4 text-white px-4 py-2 rounded-md border-0 bg-indigo-600 mx-2"
      >
        Thêm đơn hàng
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
        @click="this.openModal"
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
                Xác nhận hủy thay đổi
              </p>
              <!-- Modal description -->
              <p class="text-sm text-gray-700 dark:text-gray-400">
                Mọi thứ chưa được lưu, bạn có chắc chắc muốn rời khỏi đây ?
              </p>
            </div>
            <footer
              class="
                flex flex-row
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
              <a
                href="/admin/order"
                class="
                  w-full
                  px-5
                  py-3
                  text-center
                  bg-purple-600
                  active:bg-purple-600
                  hover:bg-purple-700
                  focus:shadow-outline-purple
                  text-white text-sm
                  font-medium
                  decoration-transparent
                  leading-5
                  text-gray-700
                  transition-colors
                  duration-150
                  rounded-lg
                  dark:text-gray-400
                  sm:px-4 sm:py-2 sm:w-auto
                  focus:border-gray-500
                  active:text-gray-500
                  focus:outline-none focus:shadow-outline-gray
                "
              >
                Chắc chắn
              </a>
              <button
                @click.prevent="closeModal"
                class="
                  w-full
                  px-5
                  py-3
                  text-sm
                  font-medium
                  leading-5
                  text-[#000000]
                  dark:text-gray-200
                  transition-colors
                  duration-150
                  border
                  dark:border-0
                  border-gray-200
                  rounded-lg
                  sm:w-auto sm:px-4 sm:py-2
                  focus:outline-none
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
import axios from "axios";
import InputFile from "./InputFileComponent";
import { mixin as clickaway } from "vue-clickaway";
import Size from "../data.json";
export default {
  mixins: [clickaway],
  props: {
    customer: null,
    address: null,
    phone: null,
    oldward: null,
    olddistrict: null,
    oldprovince: null,
    note: null,
  },
  created() {
    this.getApiProvince();
    this.getApiQuality();
    this.getApiCategory();
    this.getApiFabric();
    this.getApiIngredient();
  },
  updated() {
    // this.price = this.formatPrice(this.totalPrice - this.deposit);
    this.quantity = this.dataProperty.reduce(
      (a, b) => a + parseInt(b.quantity),
      0
    );
    // if (this.idCategorySelected != 0 && this.idQualitySelected != 0)
    //   this.getApiCost();
  },
  components: {
    InputFile,
  },
  computed: {
    totalMain() {
      return this.fabricMain.quantity * this.fabricMain.price;
    },
    totalExtra() {
      return this.fabricExtra.quantity * this.fabricExtra.price;
    },
    totalLining() {
      return this.fabricLining.quantity * this.fabricLining.price;
    },
    total() {
      return (
        this.fabricMain.quantity * this.fabricMain.price +
        this.fabricExtra.quantity * this.fabricExtra.price +
        this.fabricLining.quantity * this.fabricLining.price +
        parseInt(this.totalPrice)
      );
    },
    sum() {
      this.totalPrice = this.price * this.quantity;
      return this.totalPrice;
    },
    totalPriceIngredient() {
      let total = 0;
      this.listIngredient.map((item) => {
        total += item.quantity * item.price;
      });
      return total;
    },
  },
  data() {
    return {
      isModalOpen: false,
      dataProvince: null,
      dataDistrict: null,
      dataWard: null,
      productType: "available",
      deposit: 0,
      totalPrice: 0,
      price: 0,
      dataQuality: [],
      dataCategory: [],
      dataFabric: [],
      fabricMain: {
        price: 0,
        quantity: 0,
      },
      fabricExtra: {
        price: 0,
        quantity: 0,
      },
      fabricLining: {
        price: 0,
        quantity: 0,
      },
      dataIngredient: [],
      dataProperty: [
        {
          weight: 0,
          height: 0,
          quantity: 1,
        },
      ],
      listIngredient: [
        {
          ingredient: "",
          quantity: 1,
          price: 0,
        },
      ],
      idCategorySelected: 0,
      idQualitySelected: 0,
      quantity: 1,
      dataSize: Size,
      display: 0,
      user: {
        customer: this.customer,
        address: this.address,
        phone: this.phone,
        oldward: this.oldward,
        olddistrict: this.olddistrict,
        oldprovince: this.oldprovince,
        note: this.note,
      },
    };
  },
  methods: {
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    async getApiProvince() {
      await fetch("https://provinces.open-api.vn/api/?depth=3")
        .then((res) => res.json())
        .then((res) => (this.dataProvince = res))
        .catch((err) => console.log(err));
    },
    async getApiQuality() {
      await axios
        .get("/api/quality")
        .then((res) => (this.dataQuality = res.data))
        .catch((err) => console.log(err));
    },
    async getApiCategory() {
      await axios
        .get("/api/category")
        .then((res) => (this.dataCategory = res.data))
        .catch((err) => console.log(err));
    },
    async getApiFabric() {
      await axios
        .get("/api/fabric")
        .then((res) => (this.dataFabric = res.data))
        .catch((err) => console.log(err));
    },
    async getApiIngredient() {
      await axios
        .get("/api/ingredient")
        .then((res) => (this.dataIngredient = res.data))
        .catch((err) => console.log(err));
    },
    async getApiCost() {
      let total = 0;
      await axios
        .get(
          `admin/cost/${this.idQualitySelected}/${this.idCategorySelected}?quantity=${this.quantity}`
        )
        .then((res) => {
          if (res.data.Gia != null) total = res.data.Gia * this.quantity;
        })
        .catch((err) => console.log(err));

      this.totalPrice =
        this.productType == "unavailable"
          ? this.quantity * parseInt(this.price)
          : total;
      this.totalPrice = this.totalPrice.toString();
    },
    handleChangeProvince(e) {
      this.dataProvince.map((ele) => {
        if (ele.name === e.target.value) {
          this.dataDistrict = ele.districts;
        }
      });
    },
    handleChangeDistrict(e) {
      this.dataDistrict.forEach((ele) => {
        if (ele.name == e.target.value) this.dataWard = ele.wards;
      });
    },
    handleChecked(e) {
      this.productType = e.target.value;
    },
    handleChangeQuality(e) {
      this.idQualitySelected = e.target.value;
      // this.getApiCost();
    },
    handleChangeCategory(e) {
      this.idCategorySelected = e.target.value;
      // this.getApiCost();
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        .concat(" VND");
    },
    handleClickAddProperty() {
      this.dataProperty.push({
        weight: 0,
        height: 0,
        quantity: 1,
      });
    },
    handleClickRemoveProperty() {
      if (this.dataProperty.length > 1)
        this.dataProperty.splice(this.dataProperty.length - 1, 1);
    },
    handleClickBackDrop(e) {
      if (e.target == document.querySelector("#backdrop-overlay"))
        this.closeModal();
    },
    handleClickAddIngredient(e) {
      this.listIngredient.push({
        ingredient: "",
        quantity: 1,
        price: 0,
      });
    },
    handleClickRemoveIngredient(e) {
      if (this.listIngredient.length > 1)
        this.listIngredient.splice(this.listIngredient.length - 1, 1);
    },
    handleChangeMain(e) {
      let price = 0;
      this.dataFabric.map((item) => {
        if (item.id == e.target.value) {
          price = item.Gia;
          return;
        }
      });
      this.fabricMain.price = price;
    },
    handleChangeExtra(e) {
      let price = 0;

      this.dataFabric.map((item) => {
        if (item.id == e.target.value) {
          price = item.Gia;
          return;
        }
      });

      this.fabricExtra.price = price;
    },
    handleChangeLining(e) {
      let price = 0;
      this.dataFabric.map((item) => {
        if (item.id == e.target.value) {
          price = item.Gia;
          return;
        }
      });

      this.fabricLining.price = price;
    },
    handleChangeIngredient(e, index) {
      let price = 0;
      this.dataIngredient.map((item) => {
        if (item.id == e.target.value) price = item.Gia;
      });
      this.listIngredient[index].price = price;
    },
  },
};
</script>