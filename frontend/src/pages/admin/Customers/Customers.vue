<template>
    <div>
        <BreadcrumbDefault :pageTitle="pageTitle" :section="section" />

        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All Categories</h1>
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

                <button
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">
                    + Add New
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg">
                    <thead class="bg-gray-200  ">
                    <tr >
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider flex items-center">
                        <div class="py-2">Product ID</div>
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
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="py-2">Product</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="py-2">Price</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="py-2">Quantity</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="py-2">Sale</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="py-2">Stock</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="py-2">Start date</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                        <div class="py-2">Action</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 ">
                    <tr v-for="(product, index) in products" :key="product.id" :class="{ 'bg-gray-200': index % 2 === 1 }">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ product.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-14 w-14">
                            <img class="h-14 w-14 rounded-full" :src="product.image" :alt="product.name">
                            </div>
                            <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                            </div>
                        </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ product.price.toFixed(3) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ product.quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ product.sale }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            {{ product.stock }}
                        </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ product.startDate.toFixed(2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-4">
                            <font-awesome-icon :icon="['fas', 'eye']" class="text-blue-600 text-lg font-light" />
                        </button>
                        <button class="text-green-600 hover:text-green-900 mr-4">
                            <font-awesome-icon :icon="['fas', 'edit']" class="text-green-600 text-lg font-light" />
                        </button>
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
import { computed, onMounted, ref } from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'
import { EllipsisVerticalIcon } from '@heroicons/vue/24/solid'
import TableHeaderCell from '../../../components/admin/core/Table/TableHeaderCell.vue'
import BreadcrumbDefault from '../../../components/admin/Breadcrumbs/BreadcrumbDefault.vue'






const DEFAULT_CATEGORY = {
    id: '',
    title: '',
    description: '',
    image: '',
    price: ''
}


const categoryModel = ref({ ...DEFAULT_CATEGORY })
const showCategoryModal = ref(false);

function showAddNewModal() {
    showCategoryModal.value = true
}

function editCategory(u) {
    categoryModel.value = u;
    showAddNewModal();
}

function onModalClose() {
    categoryModel.value = { ...DEFAULT_CATEGORY }
}



const pageTitle = 'Users';
const section = 'All Users';
const products = ref([
    {
        id: '#7712309',
        name: 'Dog Food, Chicken & Chicken Liver Recipe...',
        image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg',
        price: 1452.500,
        quantity: 1638,
        sale: 20,
        stock: 'Out of stock',
        startDate: 28672.36
    },
    {
        id: '#7712309',
        name: 'Dog Food, Chicken & Chicken Liver Recipe...',
        image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg',
        price: 1452.500,
        quantity: 1638,
        sale: 20,
        stock: 'Out of stock',
        startDate: 28672.36
    },
    {
        id: '#7712309',
        name: 'Dog Food, Chicken & Chicken Liver Recipe...',
        image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg',
        price: 1452.500,
        quantity: 1638,
        sale: 20,
        stock: 'Out of stock',
        startDate: 28672.36
    },
    {
        id: '#7712309',
        name: 'Dog Food, Chicken & Chicken Liver Recipe...',
        image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg',
        price: 1452.500,
        quantity: 1638,
        sale: 20,
        stock: 'Out of stock',
        startDate: 28672.36
    },
    {
        id: '#7712309',
        name: 'Dog Food, Chicken & Chicken Liver Recipe...',
        image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg',
        price: 1452.500,
        quantity: 1638,
        sale: 20,
        stock: 'Out of stock',
        startDate: 28672.36
    },
    {
        id: '#7712309',
        name: 'Dog Food, Chicken & Chicken Liver Recipe...',
        image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg',
        price: 1452.500,
        quantity: 1638,
        sale: 20,
        stock: 'Out of stock',
        startDate: 28672.36
    },
    // Add more product objects here
]);

const fields = ['ID', 'Name', 'email', 'phone', 'status', 'Register Date', 'Actions'];
const sortField = ref('ID');
const sortDirection = ref('asc');

function handleSort(field) {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }
}

const sortedCategories = computed(() => {
    return categories.value.slice().sort((a, b) => {
        let result = 0;
        if (a[sortField.value.toLowerCase()] > b[sortField.value.toLowerCase()]) {
            result = 1;
        } else if (a[sortField.value.toLowerCase()] < b[sortField.value.toLowerCase()]) {
            result = -1;
        }
        return sortDirection.value === 'asc' ? result : -result;
    });
});


</script>
