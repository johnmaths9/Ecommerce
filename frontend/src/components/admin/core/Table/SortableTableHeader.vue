<template>
    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider flex items-center cursor-pointer" @click="$emit('sort', field)">
      <div class="py-2">{{ label }}</div>
      <div class="flex flex-col pl-3">
        <svg
          :class="{
            'text-gray-500': sortField !== field || sortDirection !== 'asc',
            'text-blue-600': sortField === field && sortDirection === 'asc'
          }"
          class="w-3 h-3"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
        </svg>
        <svg
          :class="{
            'text-gray-400': sortField !== field || sortDirection !== 'desc',
            'text-blue-500': sortField === field && sortDirection === 'desc'
          }"
          class="w-3 h-3"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </div>
    </th>
  </template>

  <script setup>
  defineProps({
    label: String,
    field: String,
    sortField: String,
    sortDirection: String
  });
  defineEmits(['sort']);
  </script>
