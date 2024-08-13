<template>
    <div class="w-full lg:flex-1 h-full">
      <div class="bg-white p-8 rounded-lg px-12 mt-6">
        <h2 class="text-2xl font-semibold text-center mb-4">Create your account</h2>
        <form @submit.prevent="register">
          <div class="mb-4">
            <label class="block text-gray-700" for="name">Full Name</label>
            <input
              type="text"
              id="name"
              v-model="name"
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
              required
            />
          </div>
          <div class="mb-4">
            <label class="block text-gray-700" for="email">Your Email</label>
            <input
              type="email"
              id="email"
              v-model="email"
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
              required
            />
          </div>
          <div class="mb-4 relative">
            <label class="block text-gray-700" for="password">Your password</label>
            <input
              :type="showPassword ? 'text' : 'password'"
              id="password"
              v-model="password"
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
              required
            />
            <span class="absolute right-3 top-1 text-gray-500 cursor-pointer" @click="togglePasswordVisibility">
              <font-awesome-icon :icon="showPassword ? ['fas', 'eye'] : ['fas', 'eye-slash']" class="gray-700 text-sm" />
              {{ showPassword ? 'Hide' : 'Show' }}
            </span>
          </div>
          <div class="mb-4 relative">
            <label class="block text-gray-700" for="password_confirmation">Confirm password</label>
            <input
              :type="showPasswordConfirm ? 'text' : 'password'"
              id="password_confirmation"
              v-model="password_confirmation"
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
              required
            />
            <span class="absolute right-3 top-1 text-gray-500 cursor-pointer" @click="togglePasswordConfirmVisibility">
              <font-awesome-icon
                :icon="showPasswordConfirm ? ['fas', 'eye'] : ['fas', 'eye-slash']"
                class="gray-700 text-sm"
              />
              {{ showPasswordConfirm ? 'Hide' : 'Show' }}
            </span>
          </div>
          <button
            type="submit"
            class="w-full py-2 mt-2 mb-4 bg-black text-white rounded-md hover:bg-gray-400 transition duration-150"
          >
            Sign up
          </button>
        </form>
        <div v-if="error" class="text-red-500 text-center mt-2">{{ error }}</div>
        <div class="text-center mt-2">
          <span>Already have an account? <router-link to="/login" class="text-primary">Sign In</router-link></span>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { useAuthStore } from '../../stores/authStore';
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';



  export default {
    name: 'SignUp',
    setup() {
        const router = useRouter();
      const authStore = useAuthStore();
      const name = ref('');
      const email = ref('');
      const password = ref('');
      const password_confirmation = ref('');
      const showPassword = ref(false);
      const showPasswordConfirm = ref(false);
      const error = ref(null);

      const register = async () => {
        try {
          await authStore.register({
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
          });
          router.push('/');
        } catch (err) {
          error.value = err.response?.data?.message || 'Registration failed';
          console.log(err)
        }
      };

      const togglePasswordVisibility = () => {
        showPassword.value = !showPassword.value;
      };

      const togglePasswordConfirmVisibility = () => {
        showPasswordConfirm.value = !showPasswordConfirm.value;
      };

      return {
        name,
        email,
        password,
        password_confirmation,
        showPassword,
        showPasswordConfirm,
        error,
        register,
        togglePasswordVisibility,
        togglePasswordConfirmVisibility,
      };
    },
  };
  </script>

  <style scoped>
  /* Add your custom styles here */
  </style>
