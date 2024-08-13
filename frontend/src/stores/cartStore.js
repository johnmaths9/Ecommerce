import { defineStore } from 'pinia';
import axios from '../axios';
import { useAuthStore } from './authStore';

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: JSON.parse(localStorage.getItem('cart')) || [],
    loading: false,
  }),
  getters: {
    cartCount: (state) => state.items.length,
    cartTotal: (state) => state.items.reduce((total, item) => total + item.quantity * item.price, 0),
  },
  actions: {
    async addToCart(product, quantity = 1) {
      this.loading = true;
      const authStore = useAuthStore();

      try {
        if (authStore.isAuthenticated) {
          const response = await axios.post('/user/cart', {
            product_id: product.id,
            quantity: quantity,
          });
        } else {
          const existingItem = this.items.find(item => item.product_id === product.id);
          if (existingItem) {
            existingItem.quantity += quantity;
          } else {
            this.items.push({
              product_id: product.id,
              name: product.name,
              price: product.price,
              image: product.images?.[0]?.url || null, // Ensure only the first image is stored
              quantity,
            });
          }
          localStorage.setItem('cart', JSON.stringify(this.items));
        }
      } catch (error) {
        console.error('Error adding to cart:', error);
      } finally {
        this.loading = false;
      }
    },
    async removeFromCart(productId) {
      this.loading = true;
      const authStore = useAuthStore();

      try {
        if (authStore.isAuthenticated) {
          await axios.delete(`/user/cart/${productId}`);
        }
        this.items = this.items.filter(item => item.product_id !== productId);
        if (!authStore.isAuthenticated) {
          localStorage.setItem('cart', JSON.stringify(this.items));
        }
      } catch (error) {
        console.error('Error removing from cart:', error);
      } finally {
        this.loading = false;
      }
    },
    async updateCart(productId, quantity) {
      this.loading = true;
      const authStore = useAuthStore();

      try {
        if (authStore.isAuthenticated) {
          await axios.put(`/user/cart/${productId}`, { quantity });
        }
        const item = this.items.find(item => item.product_id === productId);
        if (item) {
          item.quantity = quantity;
        }
        if (!authStore.isAuthenticated) {
          localStorage.setItem('cart', JSON.stringify(this.items));
        }
      } catch (error) {
        console.error('Error updating cart:', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchCart() {
      this.loading = true;
      const authStore = useAuthStore();

      try {
        if (authStore.isAuthenticated) {
          const response = await axios.get('/user/cart');
          this.items = response.data.items;
        } else {
          this.items = JSON.parse(localStorage.getItem('cart')) || [];
        }
        console.log(this.items);

      } catch (error) {
        console.error('Error fetching cart:', error);
      } finally {
        this.loading = false;
      }
    },
    clearCart() {
      this.items = [];
      localStorage.removeItem('cart');
    },
  },
});
