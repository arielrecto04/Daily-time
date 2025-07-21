<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  loading: {
    type: Boolean,
    default: true
  },
  message: {
    type: String,
    default: 'Loading...'
  }
});
</script>


<template>
  <div
    v-if="loading"
    class="absolute inset-0 w-full h-[calc(100vh-56px)] bg-white/80 backdrop-blur-sm flex items-center justify-center z-50"
  >
    <div class="text-center p-5 rounded-lg">
      <div
        class="w-12 h-12 border-4 border-gray-200 border-t-blue-500 rounded-full animate-spin mx-auto"
      ></div>
      <p
        v-if="message"
        class="mt-4 text-gray-700 font-medium text-lg"
      >
        {{ message }}
      </p>
    </div>
  </div>
</template>

