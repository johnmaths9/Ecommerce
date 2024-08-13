<template>
    <div>
        <div class="bg-black ">
            <div class="max-w-screen-2xl mx-auto flex justify-between items-center py-48 px-4 bg-cover "  :style="{ backgroundImage: `url(${imageUrl})` }">
                <div class="flex-1">
                    <div class="">
                        <div class="text-sm  rounded-md py-2 mb-4 text-gray-300 inline-block italic">This Week Only for Big Sale</div>
                        <h3 class="text-7xl font-bold text-gray-300 mb-3">Best Iphone <br> Collection Starting $255</h3><br>
                        <button class="bg-gray-300 hover:bg-gray-500 text-black text-sm py-3 px-6 font-medium" href="#">Shop Now </button>
                    </div>
                </div>
                <div class="flex-1 ">
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import imageUrl from '../../assets/bg.jpg';

export default {
  name: 'Carousel',
  data() {
    return {
      imageUrl
    };
  }
}
</script>
<style lang="">

</style>
