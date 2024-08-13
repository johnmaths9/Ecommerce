<template>
    <div>
        <BreadcrumbDefault :pageTitle="pageTitle" :section="section" />

        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Create Product</h1>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 xl:gap-4">
            <div id="section2" class="col-span-full xl:col-auto xl:order-2 order-1">
                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2">
                    <h3 class="mb-4 text-md font-semibold">Image Main</h3>
                    <div class="max-w-xl mx-auto my-10">
                        <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center cursor-pointer"
                            @dragover.prevent="onDragOver" @dragleave.prevent="onDragLeave" @drop.prevent="onDrop">
                            <input type="file" ref="fileInput" multiple @change="onFileChange" class="hidden" />
                            <p @click="triggerFileInput" class="text-gray-600">Drag & Drop Multiple images For product (or) Select</p>
                        </div>
                        <div v-if="images.length" class="mt-6 grid grid-cols-3 gap-4">
                            <div v-for="(image, index) in images" :key="index" class="relative group">
                                <img :src="image.url" :alt="'Image ' + (index + 1)"
                                    class="object-contain bg-cover h-32 w-32 rounded-lg">
                                <button @click="removeImage(index)"
                                    class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Delete</button>
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
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                                <input v-model="form.brand" type="text" id="name"
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
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old Price</label>
                                <input v-model="form.old_price" type="text" id="old_price"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="stock"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Availability</label>
                                <input v-model="form.availability" type="text" id="stock"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="category_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select v-model="form.category_id" id="category_id"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                </select>
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
                            <div class="col-span-6 sm:col-span-3">
                                <label for="discount"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                <input v-model="form.discount" type="text" id="discount"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
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
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create
                                product</button>
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


export default {
    name: 'ProductCreate',
    components: {
        BreadcrumbDefault,
        QuillEditor
    },
    data() {
        return {
            pageTitle: 'Add Product',
            section: 'E-commerce',
            form: {
                name: '',
                price: '',
                brand: '',
                old_price: '',
                availability: '',
                category_id: null,
                colors: [],
                sizes: [],
                discount: '',
                description: '',
                details:''
            },
            images: [],
            newColor: '',
            newSize: '',
            categories: [], // This should be populated with the categories available in your system.
        };
    },
    created() {
        this.fetchCategories();
    },
    methods: {
        async fetchCategories() {
            try {
                const response = await axios.get('/categories'); // Adjust the API endpoint to your needs.
                this.categories = response.data.data;
                console.log(response.data);
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        onFileChange(event) {
            const files = event.target.files;
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
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
        onDrop(event) {
            const files = event.dataTransfer.files;
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.images.push({ file, url: e.target.result });
                };
                reader.readAsDataURL(file);
            });
        },
        removeImage(index) {
            this.images.splice(index, 1);
        },
        addColor() {
            if (this.newColor && !this.form.colors.includes(this.newColor)) {
                this.form.colors.push(this.newColor);
                this.newColor = '';
            }
        },
        removeColor(color) {
            this.form.colors = this.form.colors.filter(c => c !== color);
        },
        addSize() {
            if (this.newSize && !this.form.sizes.includes(this.newSize)) {
                this.form.sizes.push(this.newSize);
                this.newSize = '';
            }
        },
        removeSize(size) {
            this.form.sizes = this.form.sizes.filter(s => s !== size);
        },
        async submitForm() {
    try {
        const formData = new FormData();

        // Append most form fields directly
        ['name', 'price', 'slug', 'brand', 'old_price', 'availability', 'category_id', 'discount', 'description'].forEach(key => {
            formData.append(key, this.form[key]);
        });

        // Handle colors and sizes as array items
        this.form.colors.forEach((color, index) => {
            formData.append(`colors[${index}]`, color);
        });
        this.form.sizes.forEach((size, index) => {
            formData.append(`sizes[${index}]`, size);
        });

        // Append images
        this.images.forEach((image, index) => {
            formData.append(`images[${index}][name]`, image.file.name);
            formData.append(`images[${index}][type]`, image.file.type);
            formData.append(`images[${index}][content]`, image.url);
        });

        // Send the request
        const response = await axios.post('/products', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        console.log('Product created successfully:', response.data);
        // Handle success (e.g., show a success message, redirect, etc.)

    } catch (error) {
        console.error('Error creating product:', error);
        // Handle error (e.g., show error message to user)
    }
}

    }
};
</script>

<style scoped>
/* Add any additional styles here */
</style>
