import { defineStore } from 'pinia';
import axios from '../axios';

export const useWishlistStore = defineStore('wishlist', {
  state: () => ({
    items: [],
    loading: false,
  }),
  getters: {
    wishlistCount: (state) => state.items.length,
  },

  actions: {
    async fetchWishlist() {
      this.loading = true;
      try {
        const response = await axios.get('/user/wishlist');
        this.items = response.data;
        console.log(response.data);

      } catch (error) {
        console.error('Failed to fetch wishlist:', error);
      } finally {
        this.loading = false;
      }
    },

    async addToWishlist(productId) {
        console.log(productId);

      try {
        const response = await axios.post('/user/wishlist', { product_id: productId });
        this.items.push(response.data);
      } catch (error) {
        console.error('Failed to add to wishlist:', error);
      }
    },

    async removeFromWishlist(productId) {
      try {
        await axios.delete(`/user/wishlist/${productId}`);
        this.items = this.items.filter(item => item?.id !== productId);

      } catch (error) {
        console.error('Failed to remove from wishlist:', error);
      }
    },
  },
});
