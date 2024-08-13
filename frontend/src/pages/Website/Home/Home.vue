<template lang="">
    <div>
        <Carousel></Carousel>
    <Tabs></Tabs>
    <ProductList></ProductList>
    </div>
</template>
<script>
import Carousel from '../../../components/common/carousel.vue'
import Tabs from '../../../components/product/components/tabs.vue'
import ProductList from '../../../components/product/ProductList.vue'
export default {
    name:'Home',
    components: {
        Carousel,
        Tabs,
        ProductList
    }}
</script>
<style lang="">

</style>
