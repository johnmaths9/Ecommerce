<template>
    <span class="text-gray-800 py-[1px] px-2 rounded-full text-sm " :class="{
        'bg-emerald-200': ['paid', 'completed'].includes(order.status),
        'bg-orange-200': order.status === 'shipped',
        'bg-red-200': order.status === 'canceled',
        'bg-gray-200': order.status === 'unpaid',
      }">{{ order.status }}</span>
  </template>

  <script setup>
  const {order} = defineProps({
    order: Object
  })
  </script>

  <style scoped>

  </style>
