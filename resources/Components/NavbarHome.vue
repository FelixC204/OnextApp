<template>
  <div>
    <button @click="toggleMobileMenu" class="md:hidden fixed top-4 left-4 z-20 text-white bg-gray-800 p-2 rounded-md">
      <MenuIcon v-if="!mobileMenuOpen" class="h-6 w-6" />
      <XIcon v-else class="h-6 w-6" />
    </button>

    <nav
      class="bg-gray-900 text-white h-screen fixed left-0 top-0 overflow-y-auto transition-all duration-300 ease-in-out"
      :class="{
        'w-64': !collapsed && !mobileMenuOpen,
        'w-20': collapsed && !mobileMenuOpen,
        'w-64': mobileMenuOpen,
        '-translate-x-full': !mobileMenuOpen && isMobile,
        'translate-x-0': mobileMenuOpen || !isMobile
      }">
      <div class="pr-6 pb-5 pt-5 flex justify-between items-center">
        <a href="/home"><img src="https://onextdigital.com/wp-content/uploads/2023/10/OnextDigital-logo.png" alt="Logo"
            class="h-8" :class="{ 'ml-auto mr-auto': collapsed && !mobileMenuOpen }"
            v-if="!collapsed || mobileMenuOpen" />
        </a>
        <button @click="toggleCollapse" class="text-gray-400 hover:text-white focus:outline-none hidden md:block ml-4">
          <img v-if="collapsed && !mobileMenuOpen"
        src="https://onextdigital.com/wp-content/uploads/2023/10/OnextDigital-logo.png" alt="Logo"
        class="h-99 mb-4 mx-auto" />
          <MenuIcon v-if="collapsed" class="h-6 w-6" />
          
          <XIcon v-else class="h-6 w-6" />
        </button>
      </div>
      <ul class="mt-6">
        <li v-for="item in menuItems" :key="item.name"
          class="relative mb-2 px-4 py-2 transition-colors duration-200 ease-in-out group"
          :class="{ 'bg-gray-800': item.href === activeItem }">
          <a @click.prevent="handleItemClick(item)" class="flex items-center cursor-pointer relative z-10">
            <component :is="item.icon" class="h-5 w-5 mr-3 transition-colors duration-200" :class="{
              'mx-auto': collapsed && !mobileMenuOpen,
              'text-gray-400 group-hover:text-white': item.href !== activeItem,
              'text-white': item.href === activeItem
            }" />
            <span v-if="!collapsed || mobileMenuOpen" :class="{
              'text-gray-400 group-hover:text-white': item.href !== activeItem,
              'text-white': item.href === activeItem
            }">
              {{ item.name }}
            </span>
          </a>
          <div
            class="absolute inset-0 bg-gray-700 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-md">
          </div>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { HomeIcon, LayersIcon, SettingsIcon, UserIcon, HelpCircleIcon, MenuIcon, XIcon, CircleFadingArrowUp } from 'lucide-vue-next'
import { useRouter } from 'vue-router'
import Swal from 'sweetalert2'

const router = useRouter()
const collapsed = ref(false)
const mobileMenuOpen = ref(false)
const isMobile = ref(false)
const activeItem = ref('')

const emit = defineEmits(['menuStateChanged'])

const menuItems = [
  { name: 'Home', icon: HomeIcon, href: '/home' },
  { name: 'Menu', icon: LayersIcon, href: '/menu' },
  { name: 'Settings', icon: SettingsIcon, href: '/settings' },
  { name: 'Profile', icon: UserIcon, href: '/profile' },
  { name: 'Help', icon: HelpCircleIcon, href: '/help' },
  { name: 'Upgrade Plan', icon: CircleFadingArrowUp, href: '/upgrade' },
  { name: 'Logout', icon: UserIcon, href: '/logout' },
]

const toggleCollapse = () => {
  if (!isMobile.value) {
    collapsed.value = !collapsed.value
    emit('menuStateChanged', !collapsed.value)
  } else {
    mobileMenuOpen.value = false
    emit('menuStateChanged', false)
  }
}

const showConfirm = (message) => {
  return Swal.fire({
    title: 'Are you sure?',
    text: message,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, logout!'
  })
}

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
  emit('menuStateChanged', mobileMenuOpen.value)
  collapsed.value = false
}

const setActiveItem = async (itemHref) => {
  if (itemHref === '/logout') {
    const result = await showConfirm('Are you sure you want to logout?')
    if (result.isConfirmed) {
      router.push('/logout')
    }
  } else {
    activeItem.value = itemHref
    router.push(itemHref)
  }
}

const checkMobile = () => {
  isMobile.value = window.innerWidth < 768
  if (!isMobile.value) {
    mobileMenuOpen.value = false
    emit('menuStateChanged', false)
  }
}

const handleItemClick = (item) => {
  setActiveItem(item.href)
  if (isMobile.value) {
    mobileMenuOpen.value = false
    emit('menuStateChanged', false)
  }
}

onMounted(() => {
  checkMobile()
  window.addEventListener('resize', checkMobile)
  setActiveItem(router.currentRoute.value.path)
})

onUnmounted(() => {
  window.removeEventListener('resize', checkMobile)
})

watch([collapsed, mobileMenuOpen], () => {
  emit('menuStateChanged', !collapsed.value || mobileMenuOpen.value)
})

watch(() => router.currentRoute.value.path, (newPath) => {
  setActiveItem(newPath)
})
</script>

<style scoped>
nav {
  transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.w-64 {
  width: 16rem;
}

.w-20 {
  width: 5rem;
}

.translate-x-0 {
  transform: translateX(0);
}

.-translate-x-full {
  transform: translateX(-100%);
}

ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

.h-99{
  width: 20px !important;
  transition: ease-in-out 0.3s;
}

.h-8{
  margin-left: 10px;
}

@media screen and (max-width: 768px) {
  .h-8 {
    margin-left: 170px;
    margin-top: 10px;
  }
}
</style>