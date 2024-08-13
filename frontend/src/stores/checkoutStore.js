// stores/checkoutStore.js
import { defineStore } from 'pinia';
import axios from '../axios';

export const useCheckoutStore = defineStore('checkout', {
  state: () => ({
    email: '',
    products: [],
    country: 'Morocco',
    firstName: '',
    lastName: '',
    address: '',
    apartment: '',
    postalCode: '',
    city: '',
    shipping: 17.91,
    paymentMethod: 'card',
    cardNumber: '',
    expiryMonth: '',
    expiryYear: '',
    cvv: '',
  }),
  getters: {
    subtotal(state) {
      return state.products.reduce((sum, product) => sum + product.price * product.quantity, 0);
    },
    total(state) {
      return this.subtotal + state.shipping;
    },
  },
  actions: {
    async fetchProducts() {
      try {
        const response = await axios.get('/user/products');
        this.products = response.data;
      } catch (error) {
        console.error('Failed to fetch products', error);
      }
    },
    async placeOrder() {
      try {
        const orderData = {
          email: this.email,
          country: this.country,
          firstName: this.firstName,
          lastName: this.lastName,
          address: this.address,
          apartment: this.apartment,
          postalCode: this.postalCode,
          city: this.city,
          products: this.products,
          shipping: this.shipping,
          paymentMethod: this.paymentMethod,
          total: this.total,
        };
        if (this.paymentMethod === 'paypal') {
          // Handle PayPal payment
          console.log('Placing order with PayPal');
        } else {
          orderData.cardNumber = this.cardNumber;
          orderData.expiryMonth = this.expiryMonth;
          orderData.expiryYear = this.expiryYear;
          orderData.cvv = this.cvv;
          // Handle card payment
          console.log('Placing order with card', orderData);
        }
        const response = await axios.post('/user/place-order', orderData);
        console.log('Order placed successfully', response.data);
      } catch (error) {
        console.error('Failed to place order', error);
      }
    },
  },
});
