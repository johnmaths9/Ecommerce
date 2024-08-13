<template>
    <footer class="bg-black text-gray-300">
      <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <section class="footer-main py-8">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
            <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-2">
              <article>
                <a href="#" class="text-2xl font-bold text-white">
                  <span class="text-2xl font-bold"><span class="text-primary">E</span>commerce</span>
                </a>
                <p class="mt-3 text-gray-400">
                  You might remember the Lenovo computer commercials in which a youth reports this exciting news to his friends.
                </p>
                <nav class="mt-4 flex flex-wrap gap-2">
                  <a class="" title="Facebook" target="_blank" href="#" @click.prevent>
                    <font-awesome-icon :icon="['fab', 'facebook']" class="text-xl text-gray-300 p-2 bg-gray-800 border border-gray-700 rounded-md" />
                  </a>
                  <a class="" title="Instagram" target="_blank" href="#" @click.prevent>
                    <font-awesome-icon :icon="['fab', 'instagram']" class="text-xl text-gray-300 p-2 bg-gray-800 border border-gray-700 rounded-md" />
                  </a>
                  <a class="" title="Youtube" target="_blank" href="#" @click.prevent>
                    <font-awesome-icon :icon="['fab', 'youtube']" class="text-xl text-gray-300 p-2 bg-gray-800 border border-gray-700 rounded-md" />
                  </a>
                  <a class="" title="Twitter" target="_blank" href="#" @click.prevent>
                    <font-awesome-icon :icon="['fab', 'twitter']" class="text-xl text-gray-300 p-2 bg-gray-800 border border-gray-700 rounded-md" />
                  </a>
                </nav>
              </article>
            </div>
            <div>
              <h6 class="text-lg font-semibold mb-4 text-white">Store</h6>
              <ul class="space-y-2 text-gray-400">
                <li><a href="#" @click.prevent class="hover:text-white">About us</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">Find store</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">Categories</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">Blogs</a></li>
              </ul>
            </div>
            <div>
              <h6 class="text-lg font-semibold mb-4 text-white">Information</h6>
              <ul class="space-y-2 text-gray-400">
                <li><a href="#" @click.prevent class="hover:text-white">Help center</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">Money refund</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">Shipping info</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">Refunds</a></li>
              </ul>
            </div>
            <div>
              <h6 class="text-lg font-semibold mb-4 text-white">Support</h6>
              <ul class="space-y-2 text-gray-400">
                <li><a href="#" @click.prevent class="hover:text-white">Help center</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">Documents</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">Account restore</a></li>
                <li><a href="#" @click.prevent class="hover:text-white">My Orders</a></li>
              </ul>
            </div>
            <div>
              <h6 class="text-lg font-semibold mb-4 text-white">Download</h6>
              <a href="#" class="block mb-2" @click.prevent>
                <img src="https://ecommerce-ui.com/uikit/images/misc/btn-appstore.png" class="h-11" alt="App Store" />
              </a>
              <a href="#" class="block mb-2" @click.prevent>
                <img src="https://ecommerce-ui.com/uikit/images/misc/btn-market.png" class="h-11" alt="Google Play" />
              </a>
            </div>
          </div>
        </section>
        <hr class="my-0 border-gray-700" />
        <section class="footer-bottom flex flex-col sm:flex-row justify-between items-center py-4">
          <div class="text-gray-400 mb-4 sm:mb-0">© 2020- 2024 Ecommerce UI.</div>
          <nav class="relative">
            <button
              class="flex items-center bg-gray-800 text-white p-2 rounded shadow"
              @click="toggleDropdown"
            >
              <img
                src="https://ecommerce-ui.com/uikit/images/flags/flag-usa.png"
                class="mr-2 h-5"
                alt="USA Flag"
              />
              <span>English</span>
              <i class="ml-2 fas fa-chevron-down"></i>
            </button>
            <ul
              v-if="isDropdownOpen"
              class="absolute right-0 bottom-full mb-2 bg-gray-800 border border-gray-700 rounded shadow-lg"
            >
              <li><a class="block px-4 py-2 text-gray-300 hover:text-white" href="#" @click.prevent>Russian</a></li>
              <li><a class="block px-4 py-2 text-gray-300 hover:text-white" href="#" @click.prevent>Arabic</a></li>
              <li><a class="block px-4 py-2 text-gray-300 hover:text-white" href="#" @click.prevent>Spanish</a></li>
            </ul>
          </nav>
        </section>
      </div>
    </footer>
  </template>

  <script>
  export default {
    name: 'Footer',
    data() {
      return {
        isDropdownOpen: false,
      };
    },
    methods: {
      toggleDropdown() {
        this.isDropdownOpen = !this.isDropdownOpen;
      },
    },
  };
  </script>

  <style scoped>
  .footer-main {
    padding: 2rem 0;
  }

  .footer-bottom {
    padding: 1rem 0;
  }
  </style>
