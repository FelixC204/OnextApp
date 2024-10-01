<template>
      <div class="min-h-screen bg-gray-100 flex items-center justify-center ">
        <div v-if="loading" class="flex justify-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-900"></div>
        </div>
        <div v-else>
          <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
              Login with Shopify
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
              Enter your Shopify store domain
            </p>
          </div>
          <form @submit.prevent="handleLogin" class="mt-8 space-y-6">
            <div class="rounded-md shadow-sm -space-y-px">
              <div>
                <label for="shop-domain" class="sr-only">Shop Domain</label>
                <div class="flex">
                  <input
                    id="shop-domain"
                    name="shop"
                    type="text"
                    required
                    v-model="shop"
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-l-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="yourstorename"
                  />
                  <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                    .myshopify.com
                  </span>
                </div>
              </div>
            </div>
  
            <div>
              <button
                type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                  <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
                </span>
                Login
              </button>
            </div>
          </form>
        </div>
      </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import Swal from 'sweetalert2'
  
  const loading = ref(true)
  const shop = ref('')
  
  onMounted(() => {
    setTimeout(() => {
      loading.value = false
    }, 100)
  
    if (localStorage.getItem('token')) {
      showError('You are already logged in! If you want to login with another account, please logout first.', '/home')
    }
  })
  
  const handleLogin = async () => {
    loading.value = true
    try {
      const response = await axios.get('/api/login', {
        params: { shop: shop.value + '.myshopify.com' },
        headers: { 'Content-Type': 'application/json' }
      })
  
      if (response.data && response.data.install_url) {
        window.location.href = response.data.install_url
      } else {
        showError(response.data.message || 'An error occurred', null)
      }
    } catch (error) {
      console.error('Login error:', error)
      showError('An error occurred while logging in. Please try again.', null)
    }
  }
  
  const showError = (message, redirect) => {
    Swal.fire({
      icon: 'warning',
      title: 'Hey!',
      text: message,
      timer: 4000,
    }).then(() => {
      if (redirect) {
        window.location.href = redirect
      }
    })
  }
  </script>