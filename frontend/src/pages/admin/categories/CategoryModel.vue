<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10" @close="show = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity" />
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full">

                            <header class="py-3 px-4 flex justify-between items-center">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    {{ category.id ? `Update category: "${props.category.name}"` : 'Create new Category'
                                    }}
                                </DialogTitle>
                                <button @click="closeModal()"
                                    class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </header>
                            <form @submit.prevent="submitForm">
                                <div class="bg-white px-4 pt-5 pb-4">
                                    <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Name</label>
                                    <input v-model="category.name" type="text" name="name" id="name"
                                    class="shadow-sm mb-4 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Category name" required>

                                    <input v-model="category.active" type="checkbox" name="active" id="active"
                                    class="shadow-sm ml-1 bg-gray-50 rounded-sm focus:outline-none focus:border-0 focus:border-transparent focus:ring-0 border-gray-300" placeholder="Active">
                                    <label for="active" class="ml-1 text-sm font-medium text-gray-900 dark:text-white">Active</label>
                                </div>

                                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                                        Submit
                                    </button>
                                    <button type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="closeModal" ref="cancelButtonRef">
                                        Cancel
                                    </button>
                                </footer>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { computed, ref, watch, onUpdated } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import axios from '../../../axios';

const category = ref({
    id: '',
    name: '',
    active: false
})

const loading = ref(false)
const errors = ref({})

const props = defineProps({
    modelValue: Boolean,
    category: {
        required: true,
        type: Object,
    }
})

const emit = defineEmits(['update:modelValue', 'close', 'categoryUpdated', 'categoryAdded'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

watch(() => props.category, (newCategory) => {
    category.value = { ...newCategory }
})

function closeModal() {
    show.value = false
    emit('close')
    errors.value = {}
}

async function submitForm() {
    try {
        loading.value = true
        if (category.value.id) {
            // Update category
            await axios.put(`/categories/${category.value.id}`, category.value)
            emit('categoryUpdated', category.value)
        } else {
            // Add new category
            console.log(category.value);
            const response = await axios.post('/categories', category.value)
            console.log(response.data +'gggg');
            emit('categoryAdded', response.data)
        }
        closeModal()
    } catch (error) {
        console.error(error)
        errors.value = error.response.data.errors || {}
    } finally {
        loading.value = false
    }
}
</script>
