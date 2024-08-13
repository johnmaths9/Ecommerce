<template>
    <div class="w-full lg:flex-1 h-full">
      <div class="bg-white p-8 rounded-lg px-12 mt-6">
        <h2 class="text-2xl font-semibold text-center mb-6">Sign into your account</h2>
        <form @submit.prevent="login">
          <div class="mb-6">
            <label class="block text-gray-700" for="email">Your Email</label>
            <input
              type="text"
              id="email"
              v-model="email"
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
            />
          </div>
          <div class="mb-6 relative">
            <label class="block text-gray-700" for="password">Your password</label>
            <input
              :type="showPassword ? 'text' : 'password'"
              id="password"
              v-model="password"
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
              required
            />
            <div class="text-right">
              <a href="#" class="text-primary">Forgot your password?</a>
            </div>
            <span class="absolute right-3 pb-2 top-1 text-gray-500 cursor-pointer" @click="togglePasswordVisibility">
              <font-awesome-icon :icon="showPassword ? ['fas', 'eye'] : ['fas', 'eye-slash']" class="gray-700 text-sm" />
              {{ showPassword ? 'Hide' : 'Show' }}
            </span>
          </div>
          <div v-if="error" class="error">
            {{ error }}
          </div>
          <button
            type="submit"
            class="w-full py-3 mt-2 mb-6 bg-black text-white rounded-md hover:bg-gray-400 transition duration-150"
          >
            Log in
          </button>
        </form>
        <div class="flex items-center mt-2 mb-4">
          <div class="flex-grow border-t border-gray-300"></div>
          <span class="mx-4 text-gray-500">OR</span>
          <div class="flex-grow border-t border-gray-300"></div>
        </div>
        <button
          class="w-full py-2 mb-6 border border-black flex items-center justify-center rounded-md hover:bg-gray-50 transition duration-150"
        >
          <font-awesome-icon
            :icon="['fab', 'facebook-f']"
            class="rounded-full w-2.5 h-2.5 bg-blue-600 text-xl p-2 text-white mr-2"
          />
          Continue with Facebook
        </button>

        <div class="text-center p-2">
          <span>Don’t have an account? <router-link to="/signup" class="text-primary">Sign up</router-link></span>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { useAuthStore } from '../../stores/authStore';
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';


  export default {
    name: 'Login',
    setup() {
      const router = useRouter();
      const authStore = useAuthStore();
      const email = ref('');
      const password = ref('');
      const showPassword = ref(false);
      const error = ref(null);

      const login = async () => {
        try {
          await authStore.login({ email: email.value, password: password.value });
          router.push('/');
        } catch (err) {
          error.value = err.response?.data?.message || 'Login failed';
        }
      };

      const togglePasswordVisibility = () => {
        showPassword.value = !showPassword.value;
      };

      return {
        email,
        password,
        showPassword,
        error,
        login,
        togglePasswordVisibility,
      };
    },
  };
  </script>

  <style scoped>
  /* Add your custom styles here */
  </style>
