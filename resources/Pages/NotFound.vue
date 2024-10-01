<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8 text-center">
        <div class="space-y-4">
          <h1 class="text-9xl font-extrabold text-gray-800 animate-bounce">
            404
          </h1>
          <h2 class="text-4xl font-bold text-gray-700">
            Page Not Found
          </h2>
          <p class="text-xl text-gray-600">
            Oops! The page you're looking for doesn't exist.
          </p>
        </div>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
          <button @click="goBack" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
            Go Back
          </button>
          <button @click="goHome" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
            Go Home
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  
  const router = useRouter()
  const searchQuery = ref('')
  
  const goBack = () => {
    router.go(-1)
  }
  
  const goHome = () => {
    router.push('/')
  }
  </script>
  
  <style scoped>
  @keyframes bounce {
    0%, 100% {
      transform: translateY(-25%);
      animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }
    50% {
      transform: translateY(0);
      animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
  }
  
  .animate-bounce {
    animation: bounce 1s infinite;
  }
  </style>