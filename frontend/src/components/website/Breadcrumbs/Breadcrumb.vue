<script setup >
const props = defineProps(['name'])
</script>

<template>
    <div class="bg-[#f5f6f8]">
        <div class="mb-8 pl-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mx-auto max-w-screen-2xl py-2">

<nav class="flex " aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-md font-medium md:space-x-2 ">
              <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-gray-800  font-light">
                  Home
                </a>
              </li>
              <li>
                <div class="flex items-center">
                    <font-awesome-icon :icon="['fas', 'caret-right']" class="text-gray-600 text-md font-light" />
                  <span class="ml-1 text-[#D44145] md:ml-2 dark:text-gray-500 text-md font-light " aria-current="page">{{ props.name }}</span>
                </div>
              </li>
            </ol>
        </nav>
<div></div>
</div>
    </div>

</template>
