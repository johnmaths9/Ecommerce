import { createApp } from 'vue';
import './style.css';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';

import { useAuthStore } from './stores/authStore';

// Add FontAwesome icons to the library
library.add(fas, far, fab);

// Create Pinia store instance
const pinia = createPinia();

// Create Vue app instance
const app = createApp(App);

// Register FontAwesomeIcon as a global component
app.component('font-awesome-icon', FontAwesomeIcon);

// Use Pinia and Vue Router in the app
app.use(pinia);
app.use(router);


// Auto-login on app load
const authStore = useAuthStore();
if (authStore.token) {
  authStore.fetchUser();
}

// Mount the app
app.mount('#app');
