<template>
    <div class="fixed top-0 right-0 h-full w-full sm:w-1/4 bg-white shadow-lg z-99 flex flex-col">
      <div class="p-4 border-b flex justify-between items-center">
        <h2 class="text-lg font-bold">My Shopping Cart</h2>
        <button @click="$emit('close')" class="text-red-600">✖</button>
      </div>

      <div v-if="loading" class="p-4 flex-1 flex items-center justify-center">
        <span>Loading...</span>
      </div>

      <div v-else-if="cartItems?.length === 0" class="p-4 flex-1 flex items-center justify-center">
        <span>Your cart is empty</span>
      </div>

      <div v-else class="p-4 overflow-y-auto flex-1">
        <div class="flex items-center justify-between mb-4" v-for="item in cartItems" :key="item.product_id">
          <img :src="`http://127.0.0.1:8000${item.image}`" alt="" class="w-20 h-20 object-cover rounded-md border-[1px] py-1 border-gray-300">
          <div class="flex-1 ml-4 mt-4">
            <h3 class="text-base font-semibold">{{ item.name }}</h3>
            <p class="text-sm font-bold text-red-600">${{ item.price }}</p>
            <div class="flex items-center mt-2">
              <button @click="decreaseQuantity(item.product_id)" class="px-4 py-1 bg-white text-black rounded-l focus:outline-none">-</button>
              <span class="px-4 py-1 bg-white text-black border-l border-r border-gray-300 flex items-center justify-center min-w-[40px]">{{ item.quantity }}</span>
              <button @click="increaseQuantity(item.product_id)" class="px-4 py-1 bg-white text-black rounded-r focus:outline-none">+</button>
              <button @click="removeItem(item.product_id)" class="ml-4 text-red-600">🗑️</button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="cartItems?.length > 0" class="p-4 border-t">
        <textarea placeholder="Order special instructions" class="w-full p-2 border rounded mb-4"></textarea>
        <div class="flex items-center justify-between mb-4">
          <span class="font-bold text-lg">Subtotal</span>
          <span class="font-bold text-lg">${{ cartTotal }}</span>
        </div>
        <router-link to="checkout">
            <button class="w-full py-2 bg-red-600 text-white rounded">CHECK OUT</button>
        </router-link>
      </div>
    </div>
  </template>

  <script setup>
  import { computed ,onMounted} from 'vue';
  import { useCartStore } from '../../../stores/cartStore';

  const cartStore = useCartStore();

  const cartItems = computed(() => cartStore.items);
  const cartTotal = computed(() => cartStore.cartTotal);
  const loading = computed(() => cartStore.loading);

  function increaseQuantity(productId) {
    const item = cartStore.items.find(item => item.product_id === productId);
    if (item) {
      cartStore.updateCart(productId, item.quantity + 1);
    }
  }

  function decreaseQuantity(productId) {
    const item = cartStore.items.find(item => item.product_id === productId);
    if (item && item.quantity > 1) {
      cartStore.updateCart(productId, item.quantity - 1);
    }
  }

  function removeItem(productId) {
    cartStore.removeFromCart(productId);
    cartStore.fetchCart()
  }

  onMounted(() => {
  cartStore.fetchCart(); // Fetch the cart items from the API or localStorage
});
  </script>
