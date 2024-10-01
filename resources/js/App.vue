<template>
    <div class="min-h-screen bg-gray-100">
      <NavigationSidebar v-if="!isLogin" @menuStateChanged="handleMenuStateChange" />
      <div class="main" :class="{ 'ml-40': menuExpanded && !isMobile, 'ml-20': !menuExpanded && !isMobile, 'ml-0': isMobile }">
        <router-view></router-view>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted, onUnmounted } from 'vue'
  import { useRoute } from 'vue-router'
  import NavigationSidebar from '../Components/NavbarHome.vue'
  
  const route = useRoute()
  const menuExpanded = ref(true)
  const isMobile = ref(false)
  
  const isLogin = computed(() => {
    return route.path === '/'
  })
  
  const handleMenuStateChange = (expanded) => {
    menuExpanded.value = expanded
  }
  
  const checkMobile = () => {
    isMobile.value = window.innerWidth < 768
  }
  
  onMounted(() => {
    checkMobile()
    window.addEventListener('resize', checkMobile)
  })
  
  onUnmounted(() => {
    window.removeEventListener('resize', checkMobile)
  })
  </script>
  
  <style>
  .main {
    transition: margin-left 0.3s ease-in-out;
  }
  </style>