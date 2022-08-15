<template>
  <div>
    <h3 class="mt-4 text-lg dark:text-gray-200 font-bold">
      Định mức tiêu hao sản phẩm
    </h3>
    <div class="flex items-center" v-for="item in this.listEle" :key="item">
      <label class="block text-sm my-2 mb-2">
        <span class="text-gray-700 dark:text-gray-400"
          >Chọn nguyên - vật liệu <span class="text-red-500">*</span></span
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
          name="id_ingredient[]"
          id="id_ingredient"
          aria-placeholder="Chọn nguyên - vật liệu"
        >
          <option value="">-- Chọn nguyên liệu --</option>
          <option v-for="ingredient in dataIngredient" :key="ingredient.id" :selected="ingredient.id === item.id_ingredient" :value="ingredient.id">{{ ingredient.Ten }}</option>
        </select>
      </label>
      <label class="block text-sm my-2 mx-2">
        <span class="text-gray-700 dark:text-gray-400"
          >Số lượng <span class="text-red-500">*</span></span
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
          placeholder="Nhập số lượng"
          min="1"
          :value="item.amount || 1"
          name="ingredient_amount[]"
        />
      </label>
    </div>
    <button @click.prevent="addOption" type="button" class="py-2 px-3 rounded-md bg-indigo-500 text-white text-sm">Thêm</button>
    <button v-if="listEle.length > 1 ? true : false" @click.prevent="removeOption" type="button" class="py-2 px-3 rounded-md bg-red-500 text-white text-sm">Bớt</button>
  </div>
</template>
<script>
export default {
  props: {
    ingredients: Array,
    selecteds: Array,
  },
  data() {
    return {
      dataIngredient: this.ingredients,
      dataSelecteds: this.selecteds,
      listEle: this.selecteds,
    };
  },
  methods:{
    addOption(){
        this.listEle.push(this.listEle.length)
    },
    removeOption(){
        if(this.listEle.length > 1){
            this.listEle.splice(-1 , 1)
        }
    }
  }
};
</script>
<style scoped>
</style>