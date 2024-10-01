<template>
  <div class="min-h-screen bg-black flex flex-col items-center justify-center">
    <div class="relative">
      <svg class="animate-spin h-24 w-24 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="h-16 w-16 bg-yellow-400 rounded-full animate-pulse"></div>
      </div>
    </div>
    <p class="mt-8 text-yellow-400 text-2xl font-bold tracking-wider animate-pulse">LOADING</p>
    <div class="mt-4 flex space-x-2">
      <div class="w-3 h-3 bg-yellow-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
      <div class="w-3 h-3 bg-yellow-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
      <div class="w-3 h-3 bg-yellow-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'

const startLoading = () => {
  document.body.style.overflow = 'hidden'
}

const stopLoading = () => {
  document.body.style.overflow = ''
}

onMounted(() => {
  startLoading()
})

onUnmounted(() => {
  stopLoading()
})
</script>

<style scoped>
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-25%); }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-bounce {
  animation: bounce 1s infinite;
}
</style>