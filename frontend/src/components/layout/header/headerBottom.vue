<template>
    <header class="bg-white shadow">
        <nav class="mx-auto flex max-w-screen-2xl items-center justify-between px-4 py-6 lg:pr-8" aria-label="Global">
            <div class="flex lg:hidden">
        <button
          type="button"
          class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
          @click="mobileMenuOpen = true"
        >
          <span class="sr-only">Open main menu</span>
          <Bars3Icon class="h-6 w-6" aria-hidden="true" />
        </button>
      </div>

      <!-- Logo -->
      <div class="flex lg:flex-1 justify-center lg:justify-start">
        <a href="#" class="-m-1.5 p-1.5">
          <span class="text-2xl font-bold text-gray-800"><span class="text-primary">E</span>commerce</span>
        </a>
      </div>

      <!-- Cart button for mobile -->
      <div class="flex lg:hidden mr-4">
        <button class="text-gray-600 hover:text-gray-800 relative" @click="toggleCart" >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
            />
          </svg>
          <span
            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-4 h-4 flex items-center justify-center"
            >{{ cartCount }}</span
          >
        </button>
      </div>

      <!-- Navbar links -->
      <PopoverGroup class="hidden lg:flex lg:gap-x-12">
        <Popover class="relative">
          <PopoverButton class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-800">
            Product
            <ChevronDownIcon class="h-5 w-5 flex-none text-gray-400" aria-hidden="true" />
          </PopoverButton>

          <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
          >
            <PopoverPanel
              class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5"
            >
              <div class="p-4">
                <div
                  v-for="item in products"
                  :key="item.name"
                  class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50"
                >
                  <div
                    class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white"
                  >
                    <component :is="item.icon" class="h-6 w-6 text-gray-600 group-hover:text-indigo-600" aria-hidden="true" />
                  </div>
                  <div class="flex-auto">
                    <a :href="item.href" class="block font-semibold text-gray-900">
                      {{ item.name }}
                      <span class="absolute inset-0" />
                    </a>
                    <p class="mt-1 text-gray-600">{{ item.description }}</p>
                  </div>
                </div>
              </div>
              <div class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50">
                <a
                  v-for="item in callsToAction"
                  :key="item.name"
                  :href="item.href"
                  class="flex items-center justify-center gap-x-2.5 p-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-100"
                >
                  <component :is="item.icon" class="h-5 w-5 flex-none text-gray-400" aria-hidden="true" />
                  {{ item.name }}
                </a>
              </div>
            </PopoverPanel>
          </transition>
        </Popover>

        <a href="#" class="text-sm font-semibold leading-6 text-gray-800">Features</a>
        <a href="#" class="text-sm font-semibold leading-6 text-gray-800">About Us</a>
        <a href="#" class="text-sm font-semibold leading-6 text-gray-800">Contact Us</a>
      </PopoverGroup>

      <!-- Search and user icons -->
      <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center space-x-4">
      <!-- Search icon and input -->
      <div class="relative">
        <button class="text-gray-800 hover:text-gray-900" @click="toggleSearch">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </button>
        <input
          v-if="showSearch"
          type="text"
          placeholder="Search..."
          class="absolute right-0 top-8 w-64 px-4 py-2 border rounded-md shadow-sm"
          @blur="showSearch = false"
        >
      </div>

        <router-link to="wishlist">
            <button class="text-gray-800 hover:text-gray-900 relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
              />
            </svg>
            <span
              class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-4 h-4 flex items-center justify-center"
              >{{wishlistCount}}</span
            >
          </button>

        </router-link>

        <!-- User icon with dropdown -->







        <!-- Cart button -->
        <button @click="toggleCart" class="text-gray-800 hover:text-gray-900 relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
            />
          </svg>
          <span
            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-4 h-4 flex items-center justify-center"
            >{{ cartCount }}</span
          >
        </button>

        <div class="relative" ref="userMenuRef">
        <button @click="toggleUserMenu" class="text-gray-800 hover:text-gray-900 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          <div v-if="isAuthenticated" class="text-gray-800 text-sm ">
          Hello, {{ userName }}
        </div>
        </button>
        <transition
          enter-active-class="transition ease-out duration-200"
          enter-from-class="opacity-0 translate-y-1"
          enter-to-class="opacity-100 translate-y-0"
          leave-active-class="transition ease-in duration-150"
          leave-from-class="opacity-100 translate-y-0"
          leave-to-class="opacity-0 translate-y-1"
        >
          <div v-if="userMenuOpen" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                <template v-if="isAuthenticated">
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Account</a>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Orders</a>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" @click="logout">Logout</a>
                </template>
                <template v-else>
                  <router-link to="/login"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Login</a></router-link>
                  <router-link to="signup"><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Register</a></router-link>
                </template>
              </div>
          </div>
        </transition>
      </div>


      </div>
    </nav>

      <Dialog class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
        <div class="fixed inset-0 z-10" />
        <DialogPanel class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
          <div class="flex items-center justify-between">
            <a href="#" class="-m-1.5 p-1.5">
              <span class="sr-only">Your Company</span>
              <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="" />
            </a>
            <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = false">
              <span class="sr-only">Close menu</span>
              <XMarkIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
              <div class="space-y-2 py-6">
                <Disclosure as="div" class="-mx-3" v-slot="{ open }">
                  <DisclosureButton
                    class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                  >
                    Product
                    <ChevronDownIcon :class="[open ? 'rotate-180' : '', 'h-5 w-5 flex-none']" aria-hidden="true" />
                  </DisclosureButton>
                  <DisclosurePanel class="mt-2 space-y-2">
                    <DisclosureButton
                      v-for="item in [...products, ...callsToAction]"
                      :key="item.name"
                      as="a"
                      :href="item.href"
                      class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                      >{{ item.name }}</DisclosureButton
                    >
                  </DisclosurePanel>
                </Disclosure>
                <a
                  href="#"
                  class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                  >Features</a
                >
                <a
                  href="#"
                  class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                  >Marketplace</a
                >
                <a
                  href="#"
                  class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                  >Company</a
                >
              </div>
              <div class="py-6">
                <a
                  href="#"
                  class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                  >Log in</a
                >
              </div>
            </div>
          </div>
        </DialogPanel>
      </Dialog>
      <ShoppingCart v-if="cartVisible" @close="toggleCart" />
    </header>
  </template>

  <script setup>
  import { useAuthStore } from '../../../stores/authStore';
  import { ref, onMounted, onUnmounted,computed  } from 'vue'
  import { useCartStore } from '../../../stores/cartStore';
  import { useWishlistStore } from '../../../stores/wishlistStore';
  import ShoppingCart from "../../website/Cart/ShoppingCart.vue"
  import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
  } from '@headlessui/vue'
  import {
    ArrowPathIcon,
    Bars3Icon,
    ChartPieIcon,
    CursorArrowRaysIcon,
    FingerPrintIcon,
    SquaresPlusIcon,
    XMarkIcon,
  } from '@heroicons/vue/24/outline'
  import { ChevronDownIcon, PhoneIcon, PlayCircleIcon } from '@heroicons/vue/20/solid'


  const products = [
    { name: 'Analytics', description: 'Get a better understanding of your traffic', href: '#', icon: ChartPieIcon },
    { name: 'Engagement', description: 'Speak directly to your customers', href: '#', icon: CursorArrowRaysIcon },
    { name: 'Security', description: 'Your customers’ data will be safe and secure', href: '#', icon: FingerPrintIcon },
    { name: 'Integrations', description: 'Connect with third-party tools', href: '#', icon: SquaresPlusIcon },
    { name: 'Automations', description: 'Build strategic funnels that will convert', href: '#', icon: ArrowPathIcon },
  ]
  const callsToAction = [
    { name: 'Watch demo', href: '#', icon: PlayCircleIcon },
    { name: 'Contact sales', href: '#', icon: PhoneIcon },
  ]


    const cartVisible = ref(false);

    function toggleCart() {
    cartVisible.value = !cartVisible.value;
    }

  const mobileMenuOpen = ref(false)
  const showSearch = ref(false);
const userMenuOpen = ref(false);
const userMenuRef = ref(null);

const authStore = useAuthStore();
const isAuthenticated = authStore.isAuthenticated;

const cartStore = useCartStore();
const wishlistStore = useWishlistStore();
const cartCount = computed(() => cartStore.cartCount);
const wishlistCount = computed(() => wishlistStore.wishlistCount);



function toggleSearch() {
  showSearch.value = !showSearch.value;
}

function toggleUserMenu() {
  userMenuOpen.value = !userMenuOpen.value;
}

function closeUserMenu(event) {
  if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
    userMenuOpen.value = false;
  }
}

onMounted(() => {
    cartStore.fetchCart()
});

onMounted(() => {
  document.addEventListener('click', closeUserMenu);
});

onUnmounted(() => {
  document.removeEventListener('click', closeUserMenu);
});

const logout = () => {
  authStore.logout();
};

const userName = computed(() => authStore.user ? authStore.user.name : '');


</script>


  <script>
  export default {
    name: 'HeaderBottom',
  }
  </script>

  <style>
  .text-primary {
    color: #4f46e5; /* Tailwind Indigo-600 */
  }
  </style>
