<template>
    <div>
        <BreadcrumbDefault :pageTitle="pageTitle" :section="section" />

        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All Categories</h1>
        </div>
        <div class=" bg-white">
            <div class="flex justify-between items-center px-6 py-6">
                <div class="flex items-center">
                    <label for="entries" class="mr-2 text-gray-700 dark:text-gray-300 text-sm">Showing</label>
                    <select id="entries" v-model="perPage"
                        @change="fetchCategories"
                        class="border border-gray-300 rounded-lg px-4 py-2 text-gray-800 dark:text-gray-300 dark:bg-gray-700 text-sm font-medium ">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="ml-2 text-gray-700 dark:text-gray-300 text-sm">entries</span>

                    <div class="relative pl-6 w-100">
                        <input type="text" placeholder="Search here..." v-model="searchQuery"
                            class="border border-gray-300 px-6 py-4 text-gray-700 dark:text-gray-300 dark:bg-gray-700 w-full text-sm rounded-lg" />

                        <font-awesome-icon :icon="['fas', 'fa-search']"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-800 dark:text-gray-300" />
                    </div>
                </div>

                <button @click="showAddNewModal"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">
                    + Add New
                </button>
                <CategoryModel v-model="showCategoryModal" :category="categoryModel" @close="onModalClose" @categoryUpdated="fetchCategories" @categoryAdded="fetchCategories" />
            </div>
            <div v-if="loading" class="flex justify-center items-center">
                Loading...
            </div>
            <div v-else>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg">
                        <thead class="bg-gray-200">
                            <tr>
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
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="category in sortedCategories" :key="category.id" :class="{ 'bg-gray-200': index % 2 === 1 }">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ category.id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ category.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ category.active ? "Yes" : "No" }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ formatDate(category.created_at) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-green-600 hover:text-green-900 mr-4" @click="showEditModal(category)">
                                        <font-awesome-icon :icon="['fas', 'edit']" class="text-green-600 text-lg font-light" />
                                    </button>
                                    <button class="text-red-600 hover:text-red-900" @click="deleteCategory(category.id)">
                                        <font-awesome-icon :icon="['fas', 'trash']" class="text-red-600 text-lg font-light" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </button>
                            <button @click="changePage(currentPage + 1)" :disabled="currentPage === lastPage"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </button>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">{{ from }}</span> to <span class="font-medium">{{ to }}</span> of <span class="font-medium">{{ total }}</span> entries
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <span v-for="page in pages" :key="page" @click="changePage(page)" :class="{'bg-blue-50 text-blue-600': page === currentPage, 'bg-white text-gray-700': page !== currentPage}"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium hover:bg-blue-100">
                                        {{ page }}
                                    </span>
                                    <button @click="changePage(currentPage + 1)" :disabled="currentPage === lastPage"
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import axios from '../../../axios';
import BreadcrumbDefault from '../../../components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import CategoryModel from './CategoryModel.vue';
import { mapState } from 'vuex';


export default {
    components: { BreadcrumbDefault, CategoryModel },
    data() {
        return {
            pageTitle: "Categories",
            section: "Dashboard",
            perPage: 10,
            searchQuery: "",
            sortField: "id",
            sortDirection: "asc",
            categories: [],
            loading: false,
            showCategoryModal: false,
            categoryModel: null,
            // Pagination
            currentPage: 1,
            lastPage: 1,
            from: 1,
            to: 10,
            total: 0,
            // Fields for the table headers
            fields: [
                { label: "ID", value: "id" },
                { label: "Name", value: "name" },
                { label: "Active", value: "active" },
                { label: "Created At", value: "created_at" },
                { label: "Actions", value: "actions" }
            ]
        };
    },
    computed: {
        sortedCategories() {
            return this.categories;
        },
        pages() {
            let pagesArray = [];
            for (let i = 1; i <= this.lastPage; i++) {
                pagesArray.push(i);
            }
            return pagesArray;
        },
    },
    methods: {
        fetchCategories() {
            this.loading = true;
            const params = {
                per_page: this.perPage,
                page: this.currentPage,
                search: this.searchQuery,
                sort_field: this.sortField,
                sort_direction: this.sortDirection
            };
            axios.get("/categories", { params }).then(response => {
                this.categories = response.data.data;
                this.currentPage = response.data.current_page;
                this.lastPage = response.data.last_page;
                this.from = response.data.from;
                this.to = response.data.to;
                this.total = response.data.total;
            }).finally(() => {
                this.loading = false;
            });
        },
        handleSort(field) {
            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === "asc" ? "desc" : "asc";
            } else {
                this.sortField = field;
                this.sortDirection = "asc";
            }
            this.fetchCategories();
        },
        showAddNewModal() {
            this.categoryModel = null;
            this.showCategoryModal = true;
        },
        showEditModal(category) {
            this.categoryModel = category;
            this.showCategoryModal = true;
        },
        deleteCategory(id) {
            if (confirm("Are you sure you want to delete this category?")) {
                axios.delete(`/categories/${id}`).then(() => {
                    this.fetchCategories();
                });
            }
        },
        onModalClose() {
            this.showCategoryModal = false;
            this.categoryModel = null;
        },
        changePage(page) {
            if (page >= 1 && page <= this.lastPage) {
                this.currentPage = page;
                this.fetchCategories();
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString();
        }
    },
    mounted() {
        this.fetchCategories();
    },
};
</script>
