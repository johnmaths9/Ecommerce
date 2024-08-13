import { defineStore } from 'pinia';
import axios from '../axios';


export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    isAuthenticated: !!localStorage.getItem('token'),
  }),
  actions: {
    async login(credentials) {
      try {
        const response = await axios.post('/login', credentials);
        this.token = response.data.access_token;
        localStorage.setItem('token', this.token);
        await this.fetchUser();
      } catch (error) {
        throw error;
      }
    },
    async register(userData) {
      try {
        const response = await axios.post('/register', userData);
        this.token = response.data.access_token;
        localStorage.setItem('token', this.token);
        await this.fetchUser();
      } catch (error) {
        throw error;
      }
    },
    async fetchUser() {
      try {
        const response = await axios.get('/user');
        this.user = response.data;
        this.isAuthenticated = true;
      } catch (error) {
        this.logout();
      }
    },
    logout() {
      this.token = null;
      this.user = null;
      this.isAuthenticated = false;
      localStorage.removeItem('token');
    }
  }
});
