<template>
    <div class="min-h-screen bg-gray-100 p-8 flex menu-builder">
      <!-- Menu Builder Panel -->
      <div class="w-1/3 bg-white shadow-lg rounded-lg p-4 mr-4">
        <h2 class="text-2xl font-bold mb-4">Menu builder</h2>
        <draggable v-model="megaMenu" item-key="id" class="space-y-2">
          <template #item="{ element }">
            <div class="bg-gray-50 p-2 rounded flex justify-between items-center">
              <div class="flex items-center">
                <span class="mr-2">:</span>
                <span class="mr-2">▶</span>
                <span>{{ element.setting.title }}</span>
              </div>
              <div>
                <button @click="editMenuItem(element)" class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                <button @click="removeMenuItem(element)" class="text-red-500 hover:text-red-700">Remove</button>
              </div>
            </div>
          </template>
        </draggable>
        <button @click="addMenuItem" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
          Add a new menu
        </button>
      </div>
  
      <!-- Preview Panel -->
      <div class="w-2/3 bg-white shadow-lg rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-bold">Preview</h2>
          <div class="flex items-center space-x-4">
            <button @click="togglePreviewMode" class="bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded">
              {{ isMobileView ? 'Mobile' : 'Desktop' }}
            </button>
            <button @click="resetMenu" class="bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded">Reset</button>
            <button @click="saveMenu" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
          </div>
        </div>
        <div :class="{ 'max-w-sm': isMobileView, 'w-full': !isMobileView }" class="border-2 border-gray-300 p-4">
          <div class="flex space-x-4">
            <template v-for="item in megaMenu" :key="item.id">
              <div class="relative group">
                <button class="hover:bg-gray-100 py-2 px-4 rounded">
                  {{ item.setting.title }}
                </button>
                <div v-if="item.menus.length > 0" class="absolute left-0 mt-2 w-48 bg-white shadow-lg rounded-lg p-2 hidden group-hover:block">
                  <template v-for="subItem in item.menus" :key="subItem.id">
                    <button class="block w-full text-left py-2 px-4 hover:bg-gray-100 rounded">
                      {{ subItem.setting.title }}
                    </button>
                  </template>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, reactive, onMounted } from 'vue';
  import draggable from 'vuedraggable';
  
  export default {
    name: 'App',
    components: {
      draggable,
    },
    setup() {
      const megaMenu = ref([
        {
          id: "tmenu-menu-852604",
          setting: { title: "Flyout / Tree", submenu_type: "flyout" },
          menus: []
        },
        {
          id: "tmenu-menu-443324",
          setting: { title: "Simple Mega", submenu_type: "mega" },
          menus: []
        }
      ]);
      const isMobileView = ref(false);
  
      const togglePreviewMode = () => {
        isMobileView.value = !isMobileView.value;
      };
  
      const addMenuItem = () => {
        // Hiện lên một modal để chọn template 

        megaMenu.value.push(newItem);
      };
  
      const editMenuItem = (item) => {
        // Implement edit functionality
        console.log('Edit item:', item);
      };
  
      const removeMenuItem = (item) => {
        const index = megaMenu.value.findIndex((i) => i.id === item.id);
        if (index !== -1) {
          megaMenu.value.splice(index, 1);
        }
      };
  
      const saveMenu = () => {
        const menuData = {
          megamenu: megaMenu.value,
          // Add other necessary fields from the original JSON
        };
        console.log('Menu JSON:', JSON.stringify(menuData, null, 2));
        // Here you would typically send this data to a server or store it
      };
  
      const resetMenu = () => {
        // Reset to initial state or load from saved configuration
        megaMenu.value = [
          {
            id: "tmenu-menu-852604",
            setting: { title: "Flyout / Tree", submenu_type: "flyout" },
            menus: []
          },
          {
            id: "tmenu-menu-443324",
            setting: { title: "Simple Mega", submenu_type: "mega" },
            menus: []
          }
        ];
      };
  
      onMounted(() => {
       
      });
  
      return {
        megaMenu,
        isMobileView,
        togglePreviewMode,
        addMenuItem,
        editMenuItem,
        removeMenuItem,
        saveMenu,
        resetMenu,
      };
    },
  };
  </script>


<style scoped>
</style>