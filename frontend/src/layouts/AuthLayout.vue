<script setup>
import HeaderMain from '../components/layout/header/headerMain.vue';
import Footer from '../components/layout/Footer/footer.vue';

</script>

<template>
  <HeaderMain />
  <!-- ====== Forms Section Start ====== -->
  <div
    class="rounded-sm border border-stroke bg-gray shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div class="flex flex-wrap items-center mx-auto max-w-screen-2xl">
      <div class="hidden w-full xl:block xl:w-1/2">
        <div class="py-17.5 px-26 text-center">

          <p class="font-medium 2xl:px-20 mt-12">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit suspendisse.
          </p>

          <span class="mt-15 inline-block">
            <img src="../assets/illustration-03.svg" alt="illustration" />
          </span>
        </div>
      </div>
      <router-view />
    </div>
  </div>
  <!-- ====== Forms Section End ====== -->
  <Footer />
</template>
<style >

</style>
