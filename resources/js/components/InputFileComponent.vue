<template>
  <div class="flex flex-row items-center justify-start input__image my-2">
    <img
      v-if="urlImg != null"
      class="w-16 h-16 rounded-lg mr-2 object-cover object-center"
      :src="this.urlImg"
    />

    <input
      @change="handleChangeFile"
      class="
        form-control
        first-line:block
        bg-clip-padding
        w-8/12
        text-sm text-gray-900
        bg-gray-50
        rounded-lg
        border border-gray-300
        cursor-pointer
        dark:text-gray-400
        focus:outline-none
        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
      "
      ref="fileImage"
      accept="image/*"
      type="file"
      name="image[]"
    />
    <a class="bg-gray-100 mx-2 rounded-lg p-1 cursor-pointer" @click="handleReload">
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
          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
        />
      </svg>
    </a>
  </div>
</template>
<script>
export default {
  data() {
    return {
      urlImg: null,
    };
  },
  methods: {
    handleChangeFile(e) {
      const image = e.target.files[0]
      this.urlImg = URL.createObjectURL(image);
    },
    handleReload(e){
        e.preventDefault()
        const input = this.$refs.fileImage
        input.type = 'text'
        input.type = 'file'
        this.urlImg = null
    }
  },
};
</script>
<style scoped>
</style>