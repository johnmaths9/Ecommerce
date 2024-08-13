<template>
    <div>
        <BreadcrumbDefault :pageTitle="pageTitle" :section="section" />

        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All products</h1>
        </div>
        <div class=" bg-white">
            <div class="flex justify-between items-center px-6 py-6">
                <div class="flex items-center">
                    <label for="entries" class="mr-2 text-gray-700 dark:text-gray-300 text-sm" >Showing</label>
                    <select id="entries"
                        class="border border-gray-300 rounded-lg px-4 py-2 text-gray-800 dark:text-gray-300 dark:bg-gray-700 text-sm font-medium ">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="ml-2 text-gray-700 dark:text-gray-300 text-sm" >entries</span>

                    <div class="relative pl-6 w-100">
                        <input type="text" placeholder="Search here..."
                            class="border border-gray-300  px-6 py-4 text-gray-700 dark:text-gray-300 dark:bg-gray-700 w-full text-sm rounded-lg"   />

                        <font-awesome-icon :icon="['fas', 'fa-search']"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-800 dark:text-gray-300" />
                    </div>
                </div>

                <router-link to="/products/add"><button
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">
                    + Add New
                </button></router-link>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg">
                    <thead class="bg-gray-200  ">
                    <tr >
                        <th v-for="field in fields" :key="field.value"
                            class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider cursor-pointer"
                            @click="handleSort(field.value)">
                            <div class="flex items-center">
                            <span>{{ field.label }}</span>
                            <div class="flex flex-col ml-2">
                                <svg :class="{'text-blue-600': sortField === field.value && sortDirection === 'asc', 'text-gray-400': sortField !== field.value || sortDirection !== 'asc'}"
                                    class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                                <svg :class="{'text-blue-600': sortField === field.value && sortDirection === 'desc', 'text-gray-400': sortField !== field.value || sortDirection !== 'desc'}"
                                    class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 ">
                    <tr v-for="(product, index) in sortedProducts" :key="product.id" :class="{ 'bg-gray-200': index % 2 === 1 }">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ product.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-14 w-14">
                            <img class="h-14 w-14 rounded-full" :src="`http://127.0.0.1:8000${product.images[0]?.url}`" :alt="product.name">
                            </div>
                            <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ truncateName(product.name) }}</div>
                            </div>
                        </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ product.category?.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ product.price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            {{ product.availability }}
                        </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="flex items-center space-x-2">
                                <font-awesome-icon
                                :icon="['fas', 'star']"
                                :class="{
                                    'text-yellow-500': product.reviews_avg_rating > 0,
                                    'text-gray-400': product.reviews_avg_rating === 0
                                }"
                                class="text-sm"
                                />
                                <!-- Conditionally display the number of ratings -->
                                <span v-if="product.reviews_count > 0" class="text-gray-600 text-sm">
                                {{ product.reviews_avg_rating }} Rating{{ product.reviews_avg_rating > 1 ? 's' : '' }}
                                </span>
                            </div>
                        </td>


                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ formatDate(product.created_at) }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-4">
                            <font-awesome-icon :icon="['fas', 'eye']" class="text-blue-600 text-lg font-light" />
                        </button>
                        <router-link :to="`/products/edit/${product.id}`"> <button class="text-green-600 hover:text-green-900 mr-4">
                            <font-awesome-icon :icon="['fas', 'edit']" class="text-green-600 text-lg font-light" />
                        </button></router-link>
                        <button class="text-red-600 hover:text-red-900">
                            <font-awesome-icon :icon="['fas', 'trash']" class="text-red-600 text-lg font-light" />
                        </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </button>
                        <button
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </button>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">10</span> entries
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination">
                                <button
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <!-- Heroicon name: solid/chevron-left -->
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    1
                                </button>
                                <button
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600 hover:bg-blue-100">
                                    2
                                </button>
                                <button
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    3
                                </button>
                                <button
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <!-- Heroicon name: solid/chevron-right -->
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from '../../../axios';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { EllipsisVerticalIcon } from '@heroicons/vue/24/solid'
import SortableTableHeader from '../../../components/admin/core/Table/SortableTableHeader.vue'
import BreadcrumbDefault from '../../../components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import { useRouter } from 'vue-router';


const pageTitle = 'Products';
const section = 'All Products';
const products = ref([]);

const fields = [
  { label: 'Product ID', value: 'id' },
  { label: 'Product', value: 'name' },
  { label: 'Category', value: 'category.name' },
  { label: 'Price', value: 'price' },
  { label: 'Availability', value: 'availability' },
  { label: 'Rate', value: 'reviews_avg_rating' },
  { label: 'Last Updated At', value: 'updated_at' },
  { label: 'Action', value: 'action' }
];
const sortField = ref('name');
const sortDirection = ref('asc');

const router = useRouter();

const deleteProduct = (id) => {
  // Add logic to delete product
  console.log('Delete product with ID:', id);
  // Show a confirmation dialog and then delete the product
  // Example:
  if (confirm('Are you sure you want to delete this product?')) {
    // Perform deletion (e.g., make an API call to delete the product)
    // After deletion, remove the product from the list
    sortedProducts.value = sortedProducts.value.filter(product => product.id !== id);
  }
};


function formatDate(dateString) {
    return dateString.split('T')[0];
}


function handleSort(field) {
    if (sortField.value === field.toLowerCase()) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field.toLowerCase();
        sortDirection.value = 'asc';
    }
}

function truncateName(name) {
        const words = name.split(' ');
        if (words.length > 4 ) {
            return words.slice(0, 4).join(' ') + '...';
        }
        return name;
}

const sortedProducts = computed(() => {
    return products.value.slice().sort((a, b) => {
        let fieldA = a[sortField.value];
        let fieldB = b[sortField.value];

        if (sortField.value === 'category') {
            fieldA = a.category.name;
            fieldB = b.category.name;
        }

        if (typeof fieldA === 'string') {
            fieldA = fieldA.toLowerCase();
            fieldB = fieldB.toLowerCase();
        }

        if (fieldA < fieldB) return sortDirection.value === 'asc' ? -1 : 1;
        if (fieldA > fieldB) return sortDirection.value === 'asc' ? 1 : -1;
        return 0;
    });
});

onMounted(async () => {
  try {
    const response = await axios.get('/products'); // Adjust this URL to your API endpoint
    products.value = response.data.data;

    products.value.forEach(product => {
      console.log(`Product ID: ${product.id}`); // Optional: Log product ID or any other identifying info
      product.images?.forEach(image => {
        console.log(image.url);
      });
    });
  } catch (error) {
    console.error('Error fetching products:', error);
  }
});
</script>
