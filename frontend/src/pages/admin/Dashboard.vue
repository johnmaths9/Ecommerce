<script setup>
import DataStatsOne from '../../components/admin/DataStats/DataStatsOne.vue'
import ChartOne from '../../components/admin/Charts/ChartOne.vue'
import ChartThree from '../../components/admin/Charts/ChartThree.vue'
import Recentorders from '../../components/admin/tables/Recentorders.vue'
import TopProducts from '../../components/admin/tables/TopProducts.vue'

</script>

<template>
  <div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
      <DataStatsOne />
    </div>

    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
      <ChartOne />
      <ChartThree />


    <div class="col-span-8 xl:col-span-8">
        <Recentorders />
    </div>

    <TopProducts/>
</div>

  </div>
</template>
