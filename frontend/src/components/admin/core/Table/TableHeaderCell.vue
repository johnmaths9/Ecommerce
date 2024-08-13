<template>
      <div @click="$emit('sort', field)"
        :class="{
          'col-span-2': field === 'Name',
          'col-span-2': field === 'created_at' ||  field === 'Category' ||  field === 'Name',
          'col-span-1': field !== 'Name' && field !== 'Category' && field !== 'CreateDate',
          'pl-5':field === 'Actions',
          'flex items-center ': true
        }"
      >
        <span>{{ field }}</span>
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
      </div>
  </template>

  <script setup>
  const props = defineProps({
    field: String,
    sortField: String,
    sortDirection: String
  })
  </script>

  <style scoped>
  .col-span-3 {
    grid-column: span 3 / span 3;
  }

  .col-span-2 {
    grid-column: span 2 / span 2 !important;
  }

  .col-span-1 {
    grid-column: span 1 / span 1;
  }
  .pl-5 {
    padding-left: 2rem;
  }
  </style>
