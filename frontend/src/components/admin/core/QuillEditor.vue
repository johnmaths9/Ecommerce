<template>
    <div>
      <label for="details" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Details</label>
      <div id="details" class="quill-editor" ref="quillContainer"></div>
    </div>
  </template>

  <script>
  import { ref, onMounted, watch } from 'vue';
  import Quill from 'quill';
  import 'quill/dist/quill.snow.css';

  export default {
    props: {
      modelValue: {
        type: String,
        default: '',
      },
    },
    setup(props, { emit }) {
      const quillContainer = ref(null);
      let quill;

      onMounted(() => {
        quill = new Quill(quillContainer.value, {
          theme: 'snow',
          placeholder: 'Enter details...',
        });
        quill.root.innerHTML = props.modelValue;

        quill.on('text-change', () => {
          emit('update:modelValue', quill.root.innerHTML);
        });
      });

      watch(() => props.modelValue, (newValue) => {
        if (quill.root.innerHTML !== newValue) {
          quill.root.innerHTML = newValue;
        }
      });

      return { quillContainer };
    },
  };
  </script>

  <style scoped>
  .quill-editor {
    @apply bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg shadow-sm  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white;
    height: 9rem; /* Approximate height for 6 rows */
  }
  </style>
