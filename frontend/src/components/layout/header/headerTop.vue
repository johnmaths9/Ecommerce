<template>
    <div class="bg-black text-white py-2">
      <div class="max-w-screen-2xl mx-auto flex justify-between items-center px-8">
        <!-- Empty div for centering the middle content -->
        <div class="flex-1"></div>

        <!-- Centered text content -->
        <div class="text-sm">
          <span>Summer Sale For All Swim Suits And Free Express Delivery - OFF 50%! </span>
          <a href="#" class="font-semibold underline">Shop Now</a>
        </div>

        <!-- Language selector -->
        <div class="flex-1 text-right text-sm flex justify-end items-center space-x-2 relative">
          <button @click="toggleDropdown" class="flex items-center space-x-1">
            <span>{{ selectedLanguage }}</span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
          <div v-if="dropdownOpen" class="absolute right-0 mt-16 w-32 bg-white text-black rounded-md shadow-lg z-10">
            <ul class="py-1">
              <li>
                <a href="#" @click="selectLanguage('English')" class="block px-4 py-2 text-sm hover:bg-gray-200">English</a>
              </li>
              <li>
                <a href="#" @click="selectLanguage('Arabic')" class="block px-4 py-2 text-sm hover:bg-gray-200">Arabic</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </template>

<script setup>
import { ref } from 'vue';

const dropdownOpen = ref(false);
const selectedLanguage = ref('English');

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value;
}

function selectLanguage(language) {
  selectedLanguage.value = language;
  dropdownOpen.value = false;
}
</script>
<script>
export default {
}
</script>
<style >
</style>
