<script setup>
// No script logic is needed for this simple static page,
// but you could import useRouter to programmatically navigate.
// import { useRouter } from 'vue-router';
// const router = useRouter();
</script>

<template>
  <div class="bg-white font-sans text-gray-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg text-center">

      <!-- 404 Status Code -->
      <h1 class="text-9xl font-extrabold text-blue-600 tracking-wider">404</h1>

      <!-- Page Title -->
      <h2 class="mt-4 text-3xl font-bold text-gray-900 tracking-tight sm:text-4xl">
        Page Not Found
      </h2>

      <!-- Helper Text -->
      <p class="mt-4 text-base text-gray-500">
        Sorry, we couldn’t find the page you’re looking for. It might have been moved, deleted, or you may have mistyped the address.
      </p>

      <!-- Action Button -->
      <div class="mt-8">
        <a
          href="/dashboard"
          class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md shadow-sm"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Go back home
        </a>
      </div>

    </div>
  </div>
</template>
