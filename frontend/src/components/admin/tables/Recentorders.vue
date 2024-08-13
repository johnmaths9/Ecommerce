<script setup>
import { ref } from 'vue'


const orders = ref([
  { number: 'N°424', orderDate: 'Jan 13, 2025', client: 'Client A', price: '$59.00', status: 'Paid' },
  { number: 'N°425', orderDate: 'Jan 14, 2025', client: 'Client B', price: '$99.00', status: 'Unpaid' },
  { number: 'N°426', orderDate: 'Jan 15, 2025', client: 'Client C', price: '$149.00', status: 'Pending' },
  { number: 'N°427', orderDate: 'Jan 16, 2025', client: 'Client D', price: '$200.00', status: 'Paid' },
  { number: 'N°428', orderDate: 'Jan 14, 2025', client: 'Client E', price: '$200.00', status: 'Paid' }
])
</script>

<template>
  <div
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
  >
    <div class="flex items-center justify-between mb-6">
        <h4 class=" text-xl font-semibold text-black dark:text-white">Recent Orders</h4>
        <a href="" class="underline text-primary">See All</a>
    </div>



    <div class="flex flex-col">
      <div class="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-5">
        <div class="p-2.5 xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Order</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Date</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Client</h5>
        </div>
        <div class="hidden p-2.5 text-center sm:block xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Price</h5>
        </div>
        <div class="hidden p-2.5 text-center sm:block xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Status</h5>
        </div>
      </div>

      <div
        v-for="(order, key) in orders"
        :key="key"
        :class="`grid grid-cols-3 sm:grid-cols-5 ${
          key === orders.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'
        }`"
      >
        <div class="flex items-center gap-3 p-2.5 xl:p-5">
          <p class="hidden text-black font-medium sm:block">{{ order.number }}</p>
        </div>

        <div class="flex items-center justify-center p-2.5 xl:p-5">
          <p class="text-black font-medium ">{{ order.orderDate }}</p>
        </div>

        <div class="flex items-center justify-center p-2.5 xl:p-5">
          <p class="text-black font-medium">{{ order.client }}</p>
        </div>

        <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
          <p class="text-black font-medium">{{ order.price }}</p>
        </div>

        <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
            <p
                class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium"
                :class="{
                  'bg-warning text-warning': order.status === 'Pending',
                  'bg-danger text-danger': order.status === 'Unpaid',
                  'bg-success text-success': order.status === 'Paid'
                }"
              >
                {{ order.status }}
              </p>
        </div>
      </div>
    </div>
  </div>
</template>
