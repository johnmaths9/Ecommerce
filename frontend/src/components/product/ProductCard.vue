<template>
    <div>
      <div
        class="item p-4 border border-[#e8e9eb] rounded-lg relative group hover:border-black transition-colors duration-300"
        @mouseover="toggleHover(true)"
        @mouseleave="toggleHover(false)"
      >
        <div class="product-item-info">
          <div class="mb-4 relative">
            <a :href="productUrl" class="product photo product-item-photo" tabindex="-1">
              <span class="product-image-container block w-full h-full overflow-hidden relative pr-3">
                <img
                  class="product-image-photo w-full h-full absolute top-0 left-0 transition-transform duration-300 ease-in-out transform"
                  :class="{ 'translate-x-full': hover, 'translate-x-0': !hover }"
                  :src="`http://127.0.0.1:8000${mainImageUrl}`"
                  :alt="productTitle"
                  loading="lazy"
                  style="object-fit: cover;"
                />
                <img
                  class="product-image-photo w-full h-full absolute top-0 left-0 transition-transform duration-300 ease-in-out transform"
                  :class="{ 'translate-x-0': hover, '-translate-x-full': !hover }"
                  :src="`http://127.0.0.1:8000${hoverImageUrl}`"
                  :alt="productTitle"
                  loading="lazy"
                  style="object-fit: cover;"
                />
              </span>
            </a>
            <div class="absolute top-2 right-0 flex flex-col items-center space-y-2">
              <button class="bg-white rounded-full p-2 shadow" @click="addProductToWishlist(id)">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-4 h-4 text-gray-500"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09A6.487 6.487 0 0116.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                  />
                </svg>
              </button>
              <button @click="addToCart(product)" class="bg-white rounded-full p-2 shadow opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <font-awesome-icon :icon="['far', 'eye']" class="text-gray-500 w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="flex items-end justify-between py-4 px-2">
        <div>
          <strong class="block mb-1">
            <a class="text-md font-normal text-gray-800" :href="productUrl">
              {{ productTitle }}
            </a>
          </strong>
          <div class="text-xs text-gray-500 mb-2">
            <span class="flex items-center gap-1 text-xs">
              <font-awesome-icon v-for="i in 5" :key="i" :icon="['fas', 'star']" :class="{'text-yellow-500': i <= reviews_avg_rating, 'text-gray-400': i > reviews_avg_rating}" />
            </span>
          </div>
          <div>
            <span class="flex gap-3 items-center">
              <span class="text-red-500 font-bold text-md">{{ `$${price}` }}</span>
              <span v-if="old_price" class="text-gray-400 line-through text-sm">{{ `$${old_price}` }}</span>
            </span>
          </div>
        </div>
        <font-awesome-icon @click="addToCart(product)" :icon="['fas', 'cart-shopping']" class="text-md text-red-700 p-2 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 cursor-pointer" />
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue';
  import { useCartStore } from '../../stores/cartStore'; // Adjust the import path if necessary
  import { useWishlistStore } from '../../stores/wishlistStore';

  const wishlistStore = useWishlistStore();
  const cartStore = useCartStore();
  const props = defineProps({
    product: Object
  });

  const hover = ref(false);
  const id = computed(() => props.product.id)
  const productTitle = computed(() => props.product.name || 'Product Title');
  const productUrl = computed(() => `/product/${props.product.slug}`);
  const mainImageUrl = computed(() => props.product.images?.[0]?.url || '');
  const hoverImageUrl = computed(() => props.product.images?.[1]?.url || mainImageUrl.value);
  const price = computed(() => props.product.price);
  const old_price = computed(() => props.product.old_price);
  const reviews_avg_rating = computed(() => props.product.reviews_avg_rating);

  function toggleHover(state) {
    hover.value = state;
  }

  function addToCart(product) {
    cartStore.addToCart(product, 1); // Adjust quantity as needed
    cartStore.fetchCart()
  }




function addProductToWishlist(productId) {
  wishlistStore.addToWishlist(productId);
}
  </script>

  <style scoped>
  .product-image-container {
    aspect-ratio: 1;
  }
  .group:hover .product-image-photo {
    opacity: 0.7;
  }
  </style>
