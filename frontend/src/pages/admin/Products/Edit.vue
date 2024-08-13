<template>
    <div>
        <BreadcrumbDefault :pageTitle="pageTitle" :section="section" />

        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Edit Product</h1>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 xl:gap-4">
            <div id="section2" class="col-span-full xl:col-auto xl:order-2 order-1">
                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2">
                    <h3 class="mb-4 text-md font-semibold">Image Main</h3>
                    <div class="max-w-xl mx-auto my-10">
                        <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center cursor-pointer"
                            @dragover.prevent="onDragOver" @dragleave.prevent="onDragLeave" @drop.prevent="onDrop">
                            <input type="file" ref="fileInput" multiple @change="onFileChange" class="hidden"
                                accept="image/*" />
                            <p @click="triggerFileInput" class="text-gray-600">Drag & Drop Multiple images For product
                                (or) Select</p>
                        </div>
                        <div v-if="images.length" class="mt-6 grid grid-cols-3 gap-4">
                            <div v-for="(image, index) in images" :key="index" class="relative group">
                                <img :src="getImageUrl(image)" :alt="'Image ' + (index + 1)"
                                    class="object-contain bg-cover h-32 w-32 rounded-lg"
                                    :class="{ 'opacity-50': image.toBeDeleted }">
                                <div v-if="image.toBeDeleted"
                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-xs">
                                    To be deleted
                                </div>
                                <button @click="removeImage(index)"
                                    class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{ image.toBeDeleted ? 'Undo' : 'Delete' }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-span-2 xl:order-1 order-2">
                <div
                    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input v-model="form.name" type="text" id="name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="brand"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                                <input v-model="form.brand" type="text" id="brand"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="price"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                <input v-model="form.price" type="text" id="price"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="old_price"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old
                                    Price</label>
                                <input v-model="form.old_price" type="text" id="old_price"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="availability"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Availability</label>
                                <input v-model="form.availability" type="text" id="availability"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="category_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select v-model="form.category_id" id="category_id"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{
                                        category.name }}</option>
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="discount"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                <input v-model="form.discount_percentage" type="text" id="discount"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="colors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Colors</label>
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <div v-for="color in form.colors" :key="color"
                                        class="bg-gray-200 dark:bg-gray-600 rounded-full px-3 py-1 text-sm flex items-center">
                                        <span class="w-4 h-4 rounded-full mr-2"
                                            :style="{ backgroundColor: color }"></span>
                                        {{ color }}
                                        <button @click.prevent="removeColor(color)"
                                            class="ml-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">&times;</button>
                                    </div>
                                </div>
                                <div class="flex">
                                    <input v-model="newColor" @keyup.enter="addColor" placeholder="Enter color"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-l-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <button @click.prevent="addColor"
                                        class="text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-r-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="sizes"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sizes</label>
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <div v-for="size in form.sizes" :key="size"
                                        class="bg-gray-200 dark:bg-gray-600 rounded-full px-3 py-1 text-sm flex items-center">
                                        {{ size }}
                                        <button @click.prevent="removeSize(size)"
                                            class="ml-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">&times;</button>
                                    </div>
                                </div>
                                <div class="flex">
                                    <input v-model="newSize" @keyup.enter="addSize" placeholder="Enter size"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-l-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <button @click.prevent="addSize"
                                        class="text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-r-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-6">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea v-model="form.description" id="description" rows="4"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
                            </div>
                            <div class="col-span-6">
                                <QuillEditor v-model="form.details" />

                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from '../../../axios';
import BreadcrumbDefault from '../../../components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import QuillEditor from '../../../components/admin/core/QuillEditor.vue';

import { onBeforeUnmount } from 'vue';


export default {
    name: "ProductEdit",
    components: {
        BreadcrumbDefault,
        QuillEditor
    },

    data() {
        return {
            pageTitle: "Edit Product",
            section: "Products",
            form: {
                name: "",
                availability: "",
                brand: "",
                price: "",
                old_price: "",
                description: "",
                details: "",
                category_id: "",
                discount_percentage: '',
                colors: [],
                sizes: [],
            },
            categories: [],
            newColor: "",
            newSize: "",
            images: [],
            newImages: [],
            deletedImageIds: [],
        };
    },
    created() {
        this.loadCategories();
        this.loadProduct();
    },
    methods: {
        async loadProduct() {
            const productId = this.$route.params.id;
            try {
                const response = await axios.get(`/products/${productId}`);
                this.form = { ...response.data, colors: response.data.colors || [], sizes: response.data.sizes || [] };
                this.images = response.data.images || [];
            } catch (error) {
                console.error("Error loading product:", error);
            }
        },
        async loadCategories() {
            try {
                const response = await axios.get('/categories');
                this.categories = response.data.data;
            } catch (error) {
                console.error("Error loading categories:", error);
            }
        },
        async submitForm() {
            const productId = this.$route.params.id;
            try {
                const formData = new FormData();

                // Append all form fields
                Object.keys(this.form).forEach(key => {
                    if (Array.isArray(this.form[key])) {
                        this.form[key].forEach(item => formData.append(`${key}[]`, item));
                    } else {
                        formData.append(key, this.form[key]);
                    }
                });

                // Handle new images


                this.newImages.forEach((image, index) => {
                    formData.append(`new_images[${index}][name]`, image.file.name);
                    formData.append(`new_images[${index}][type]`, image.file.type);
                    formData.append(`new_images[${index}][content]`, image.url);
                });

                // Handle deleted images
                this.deletedImageIds.forEach(id => formData.append('deleted_images[]', id));

                // Log formData contents (for debugging)
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                await axios.post(`/products/${productId}?_method=PUT`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.$router.push('/products/all');
            } catch (error) {
                console.error("Error updating product:", error);
                if (error.response && error.response.data) {
                    console.error("Server response:", error.response.data);
                }
            }
        },


        undoDeleteImage(index) {
            if (this.images[index].id) {
                this.images[index].toBeDeleted = false;
            }
        },

        addColor() {
            if (this.newColor && !this.form.colors.includes(this.newColor)) {
                this.form.colors.push(this.newColor);
                this.newColor = "";
            }
        },
        removeColor(color) {
            this.form.colors = this.form.colors.filter(c => c !== color);
        },
        addSize() {
            if (this.newSize && !this.form.sizes.includes(this.newSize)) {
                this.form.sizes.push(this.newSize);
                this.newSize = "";
            }
        },
        removeSize(size) {
            this.form.sizes = this.form.sizes.filter(s => s !== size);
        },
        onFileChange(event) {

            const files = event.target.files;
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.newImages.push({ file, url: e.target.result });
                    this.images.push({ file, url: e.target.result });
                };
                reader.readAsDataURL(file);
            });
        },

        onDrop(event) {
            const files = event.target.files;
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.newImages.push({ file, url: e.target.result });
                    this.images.push({ file, url: e.target.result });
                };
                reader.readAsDataURL(file);
            });
        },


        onDragOver(event) {
            event.preventDefault();
        },
        onDragLeave(event) {
            event.preventDefault();
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        removeImage(index) {
            const image = this.images[index];
            if (image.id) {
                // If the image has an ID, it's an existing image
                this.deletedImageIds.push(image.id);
            }
            this.images.splice(index, 1);
        },
        getImageUrl(image) {
            if (image.file && typeof URL !== 'undefined' && URL.createObjectURL) {
                return URL.createObjectURL(image.file);
            } else if (image.url && image.url.startsWith('/storage')) {
                return `http://127.0.0.1:8000${image.url}`;
            } else {
                return ''; // or a placeholder image URL
            }
        },
    },
};
</script>

<style scoped>
/* Add your styles here */
</style>
