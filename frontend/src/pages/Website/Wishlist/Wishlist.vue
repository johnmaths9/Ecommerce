<template lang="">
    <div>
        <Breadcrumb :name="name" />
        <div class="container mx-auto p-4 mb-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Your wishlist</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <div v-for="item in wishlistItems" :key="item.id" class="bg-white p-4 rounded shadow">
        <div class="relative group">
          <img :src="`http://127.0.0.1:8000${item.image}`" :alt="item.name" class="w-full h-60 object-contain mb-4">
          <!-- Hover overlay -->
          <div class="absolute top-2 right-2 flex flex-col space-y-2 sm:hidden pt-12">
            <button class="p-2 bg-white rounded-full shadow">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </button>
            <button class="p-2 bg-white rounded-full shadow">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
            <button class="p-2 bg-white rounded-full shadow">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
            </button>
          </div>
          <!-- Hover overlay for larger screens -->
          <div class="absolute inset-0 bg-black bg-opacity-50 items-end justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-3 hidden sm:flex">
            <div class="flex space-x-4">
              <button class="p-2 bg-white rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </button>
              <router-link :to="`/product/${item.slug}`"><button class="p-2 bg-white rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button></router-link>
              <button class="p-2 bg-white rounded-full" @click="removeFromWishlist(item.id)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <h2 class="text-lg font-semibold mb-2 text-gray-800 text-center">{{ item.name }}</h2>
        <div class="flex justify-center items-center gap-2">
          <span class="font-bold text-red-700">${{ item.price }}</span>
          <span class="text-gray-500 line-through">${{ item.old_price }}</span>
        </div>
      </div>
    </div>
  </div>
    </div>
</template>

<script setup>
import { ref, onMounted,computed } from 'vue';
import { useWishlistStore } from '../../../stores/wishlistStore';
import Breadcrumb from '../../../components/website/Breadcrumbs/Breadcrumb.vue'

const name = "WishList";

// Pinia store
const wishlistStore = useWishlistStore();

const wishlistItems = computed(() => wishlistStore.items);
function removeFromWishlist(productId) {
    console.log(productId);

  wishlistStore.removeFromWishlist(productId);
}

onMounted(() => {
  wishlistStore.fetchWishlist();
});



</script>

<style >

</style>
