<template>
    <div>
      <!-- Header Top - Not Fixed -->
      <header class="header-top">
        <HeaderTop />
      </header>

      <!-- Header Bottom - Initially Not Fixed, will become fixed on scroll -->
      <header :class="['header-bottom', { 'fixed-header': isFixed }]">
        <HeaderBottom />
      </header>
    </div>
  </template>

  <script>
  import { ref, onMounted, onBeforeUnmount } from 'vue'
  import HeaderTop from './headerTop.vue'
  import HeaderBottom from './headerBottom.vue'

  export default {
    name: 'HeaderMain',
    components: {
      HeaderTop,
      HeaderBottom,
    },
    setup() {
      const isFixed = ref(false)

      const handleScroll = () => {
        isFixed.value = window.scrollY > 50 // Adjust this value as needed
      }

      onMounted(() => {
        window.addEventListener('scroll', handleScroll)
      })

      onBeforeUnmount(() => {
        window.removeEventListener('scroll', handleScroll)
      })

      return {
        isFixed,
      }
    },
  }
  </script>

  <style scoped>
  .header-top {
    position: relative;
    width: 100%;
  }

  .header-bottom {
    width: 100%;
    transition: all 0.3s ease;
  }

  .fixed-header {
    position: fixed;
    top: 0;
    left: 0;
    background-color: white;
    z-index: 50;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for visual separation */
  }
  </style>
