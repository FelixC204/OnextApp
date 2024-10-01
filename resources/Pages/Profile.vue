<template>
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Account detail</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Profile Information -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
              <h2 class="text-lg leading-6 font-medium text-gray-900">Profile</h2>
            </div>
            <div class="border-t border-gray-200">
              <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">Shop owner</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ profile.shopOwner || 'N/A' }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                  <dt class="text-sm font-medium text-gray-500">My Shopify domain</dt>
                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ profile.shopifyDomain || 'N/A' }}</dd>
                </div>
              </dl>
            </div>
          </div>
  
          <!-- Subscription Details -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
              <h2 class="text-lg leading-6 font-medium text-gray-900">
                {{ subscription.name }}
                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  {{ subscription.type }}
                </span>
              </h2>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
              <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ subscription.description }}
              </p>
              <div class="mt-6">
                <button @click="cancelSubscription"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                  Cancel subscription
                </button>
                <button
                  class="ml-8 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-700 hover:bg-blue-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  Update Plan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const profile = ref({
  shopOwner: '',
  shopifyDomain: ''
});

const subscription = ref({
  name: 'qikify Mega Menu & Navigation Basic',
  type: 'Free for Development Store',
  description: 'You are in Basic plan with no charge applied. If your store transfers to a Shopify live plan, you will be back to Free plan and all premium features will be disabled until your client approves to charge (all data remain intact).'
});

const fetchProfile = async () => {
  try {
    const response = await axios.post('/api/profile', {
      shop_domain: localStorage.getItem('shop')
    }, {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + localStorage.getItem('token')
      }
    });

    profile.value = {
      shopOwner: response.data.shop_owner,
      shopifyDomain: response.data.shop_domain
    };

    // Lưu thông tin vào localStorage
    localStorage.setItem('shopOwner', profile.value.shopOwner);
    localStorage.setItem('shopifyDomain', profile.value.shopifyDomain);

  } catch (error) {
    console.error('Error fetching profile:', error);
  }
};

const loadProfileFromStorage = () => {
  const shopOwner = localStorage.getItem('shopOwner');
  const shopifyDomain = localStorage.getItem('shopifyDomain');
  
  if (shopOwner && shopifyDomain) {
    profile.value = {
      shopOwner,
      shopifyDomain
    };
    return true;
  }
  return false;
};

const cancelSubscription = () => {
  console.log('Subscription cancelled');
};

onMounted(() => {
  if (!loadProfileFromStorage()) {
    fetchProfile();
  }
});
</script>