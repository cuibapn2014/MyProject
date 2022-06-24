<template>
  <div class="flex flex-wrap justify-start">
    <div
      class="lg:w-4/12 md:w-2/4 sm:w-full h-auto p-2 relative"
      v-for="item in assign.slice().reverse()"
      :key="item.id"
    >
    <span
    v-if="getExpired(item)" 
    class="h-2 w-2 animate-ping right-5 top-5 absolute rounded-full bg-red-500 text-white font-bold"></span>
      <div
        class="
          flex flex-col
          w-full
          bg-[#ffffff]
          p-3
          h-full
          shadow-sm
          rounded-lg
          dark:bg-gray-800 dark:text-gray-200
        "
      >
        <p class="text-base border-bottom py-2 font-bold">#{{ item.task.tieu_de }}</p>
        <p class="py-2 border-bottom grow">
          {{ item.task.chi_tiet }}
        </p>
        <div class="flex items-center flex-nowrap justify-between pt-2">
          <p class="flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5 mx-1"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                clip-rule="evenodd"
              />
            </svg>
            bởi {{ item.task.user.name }}
          </p>
          <p class="flex items-center text-md">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4 mx-1"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            {{ new Date(item.task.ngay_hoan_thanh).toLocaleDateString() }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    assign: Array,
  },
  methods:{
    getExpired(item){
      return (new Date().getTime() - new Date(item.task.created_at).getTime()) < 900000
    }
  },
  data() {
    return {
      data: null,
    };
  },
};
</script>
<style scoped>
</style>