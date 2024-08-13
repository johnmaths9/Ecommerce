<template>
    <div>
        <BreadcrumbDefault :pageTitle="pageTitle" :section="section" />

        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All Categories</h1>
        </div>
        <div
            class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700 mb-4">
            <div class="flex items-center mb-4 sm:mb-0">
                <form class="sm:pr-3" action="#" method="GET">
                    <label for="products-search" class="sr-only">Search</label>
                    <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                        <input type="text" name="email" id="products-search"
                            class="bg-gray-50 border border-[rgb(209,213,219)] text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Search for categories" />
                    </div>
                </form>
                <div class="flex items-center w-full sm:justify-end">
                    <div class="flex pl-2 space-x-1">
                        <a href="#"
                            class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6 text-[rgb(107,114,128)]" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                            class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6 text-[rgb(107,114,128)]" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                            class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6 text-[rgb(107,114,128)]" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                            class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6 text-[rgb(107,114,128)]" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
                <button id="createProductButton" @click="showAddNewModal()"
                    class="flex items-center text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"
                    type="button" data-drawer-target="drawer-create-product-default"
                    data-drawer-show="drawer-create-product-default" aria-controls="drawer-create-product-default"
                    data-drawer-placement="right">
                    <svg class="text-white w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add new category
                </button>
                <CategoryModel v-model="showCategoryModal" :category="categoryModel" @close="onModalClose"/>
        </div>

        <div
            class="rounded-sm border mt-6 border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <!-- Table Header -->
            <div
                class="grid grid-cols-4 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <TableHeaderCell
              v-for="field in fields"
              :key="field"
              :field="field"
              :sort-field="sortField"
              :sort-direction="sortDirection"
              @sort="handleSort"
            />
            </div>

            <div v-for="(category, index) in sortedCategories " :key="index"
                class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                <div class="col-span-1 hidden items-center sm:flex">
                    <p class="text-sm text-black dark:text-white">{{ category.id }}</p>
                </div>
                <div class="col-span-3 flex items-center">
                    <p class="text-sm font-medium text-black dark:text-white">{{ category.name }}</p>
                </div>
                <div class="col-span-1 hidden items-center sm:flex">
                    <p class="text-sm text-black dark:text-white">{{ category.email }}</p>
                </div>
                <div class="col-span-2 flex items-center">
                    <p class="text-sm font-medium text-black dark:text-white">{{ category.createdate }}</p>
                </div>
                <div class="col-span-1 flex items-center ">
                    <Menu as="div" class="relative inline-block text-left">
                        <MenuButton
                            class="flex items-center text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <EllipsisVerticalIcon class="w-5 h-5 text-indigo-500" aria-hidden="true" />
                        </MenuButton>
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <MenuItem v-slot="{active}">
                                    <a href="#" :class="[
                                        active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                        'block px-4 py-2 text-sm',
                                    ]">
                                        Edit
                                    </a>
                                    </MenuItem>
                                    <MenuItem v-slot="{active}">
                                    <a href="#" :class="[
                                        active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                        'block px-4 py-2 text-sm',
                                    ]">
                                        Delete
                                    </a>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>

    </div>


</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle} from '@headlessui/vue'
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


const categoryModel = ref({...DEFAULT_CATEGORY})
const showCategoryModal = ref(false);

function showAddNewModal() {
  showCategoryModal.value = true
}

function editCategory(u) {
    categoryModel.value = u;
    showAddNewModal();
}

function onModalClose() {
  categoryModel.value = {...DEFAULT_CATEGORY}
}



const pageTitle = 'Users';
const section = 'All Users';
const categories = ref([
  {
    id: 1,
    name: 'John Doe',
    email: 'john.doe@example.com',
    createdate: '2023-01-01'
  },
  {
    id: 2,
    name: 'Jane Smith',
    email: 'jane.smith@example.com',
    createdate: '2023-02-15'
  },
  {
    id: 3,
    name: 'Alice Johnson',
    email: 'alice.johnson@example.com',
    createdate: '2023-03-10'
  },
  {
    id: 4,
    name: 'Bob Brown',
    email: 'bob.brown@example.com',
    createdate: '2023-04-05'
  },
  {
    id: 5,
    name: 'Charlie Davis',
    email: 'charlie.davis@example.com',
    createdate: '2023-05-20'
  },
]);

const fields = ['ID', 'Name', 'email', 'CreateDate', 'Actions'];
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
