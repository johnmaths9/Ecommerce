<template>
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden bg-[rgb(241,245,249)]">
      <!-- ===== Sidebar Start ===== -->
      <SidebarArea />
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        <!-- ===== Header Start ===== -->
        <HeaderArea />
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="mx-auto max-w-screen-2xl py-2 px-4 md:p-6 2xl:px-10">
            <router-view />
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
    </div>
    <!-- ===== Page Wrapper End ===== -->
  </template>

  <script>
  import HeaderArea from '../components/admin/Header/HeaderArea.vue'
  import SidebarArea from '../components/admin/Sidebar/SidebarArea.vue'

  export default {
    name: 'AdminLayout',
    components: {
      HeaderArea,
      SidebarArea
    }
  }
  </script>

  <style scoped>
  /* Add your styles here */
  </style>
