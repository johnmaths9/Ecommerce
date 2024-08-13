<template>
    <HeaderMain></HeaderMain>
    <router-view />
    <Footer></Footer>
</template>

<script>

import HeaderMain from '../components/layout/header/headerMain.vue'
import Carousel from '../components/common/carousel.vue'
import Tabs from '../components/product/components/tabs.vue'
import ProductList from '../components/product/ProductList.vue'
import Footer from '../components/layout/Footer/footer.vue';
export default {
    name:'DefaultLayout',
    components: {
      HeaderMain,
      Footer,
    }}
</script>
