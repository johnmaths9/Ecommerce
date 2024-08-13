<template>
    <div class="max-w-screen-2xl mx-auto px-3 products-list grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 my-10">
      <ProductItem
        v-for="product in products"
        :key="product.id"
        :product="product"
      />
    </div>
  </template>

  <script>
  import ProductItem from './ProductCard.vue';
  import axios from '../../axios';

  export default {
    name: 'ProductList',
    components: {
      ProductItem,
    },
    data() {
      return {
        products: [],
      };
    },
    created() {
      this.fetchProducts();
    },
    methods: {
      async fetchProducts() {
        try {
          const response = await axios.get('/user/products'); // Update the URL if needed
          this.products = response.data;
        } catch (error) {
          console.error('Error fetching products:', error);
        }
      },
    },
  };
  </script>

  <style scoped>
  .products-list {
    display: grid;
    gap: 1rem;
  }
  </style>
