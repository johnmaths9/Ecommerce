<template>
    <div v-if="product">
        <Breadcrumb :name="product.name" />
        <div class="mx-auto max-w-screen-2xl py-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Main Content -->
                <div class="col-span-1 md:col-span-12 lg:col-span-9 bg-white p-6">
                    <div class="flex flex-col md:flex-row">
                        <!-- Product Image -->
                        <div class="w-full md:w-1/2 relative mb-6 md:mb-0">
                            <div class="relative">
                                <img ref="productImage" :src="images[currentImageIndex]" alt="Product Image"
                                    class="w-full" @mousemove="handleMouseMove" @mouseleave="handleMouseLeave" />
                                <div class="arrow-area left-arrow" @mouseover="hideZoom" @mouseleave="showZoom">
                                    <button @click="prevImage" class="arrow-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-10 h-10 bg-white shadow-md rounded-full p-2">
                                            <path fill-rule="evenodd"
                                                d="M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="arrow-area right-arrow" @mouseover="hideZoom" @mouseleave="showZoom">
                                    <button @click="nextImage" class="arrow-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-10 h-10 bg-white shadow-md rounded-full p-2">
                                            <path fill-rule="evenodd"
                                                d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div v-show="isZoomed && !isArrowHovered" ref="zoomResult" class="zoom-result"
                                    :style="zoomStyle"></div>
                            </div>
                            <div class="flex justify-center mt-4">
                                <div class="md:hidden flex">
                                    <span v-for="(image, index) in images" :key="`dot-${index}`"
                                        class="w-2 h-2 rounded-full bg-gray-500 mx-1 cursor-pointer"
                                        :class="{ 'bg-blue-500': index === currentImageIndex }"
                                        @click="setCurrentImage(index)"></span>
                                </div>
                                <div class="hidden md:flex">
                                    <img v-for="(image, index) in images" :key="`thumb-${index}`" :src="image"
                                        :alt="`Thumbnail ${index + 1}`"
                                        class="w-30 h-30 object-cover border-2 mr-2 cursor-pointer"
                                        :class="{ 'border-blue-500': index === currentImageIndex, 'border-transparent': index !== currentImageIndex }"
                                        @click="setCurrentImage(index)" />
                                </div>
                            </div>

                        </div>
                        <!-- Product Details -->
                        <div class="w-full md:w-1/2 md:pl-6 pt-4">
                            <h1 class="text-2xl text-gray-800 font-semibold mb-2">{{ product.name }}</h1>
                            <p class="font-semibold text-gray-800 text-md mb-6 border-b-2 pb-2 mr-4"> Brand <span
                                    class="font-normal ml-1 text-gray-600 italic">#{{ product.brand }}</span></p>
                            <div class="flex items-center mb-4 gap-3 text-sm">
                                <div>
                                    <font-awesome-icon v-for="i in 5" :key="i" class="text-sm"
                                     :icon="['fas', 'star']" :class="{'text-yellow-500': i <= product.reviews_avg_rating, 'text-gray-400': i > product.reviews_avg_rating}" />
                                    <span class="ml-2 text-[#727272]">{{ product.reviews.length }} Review{{ product.reviews.length !== 1 ? 's' : '' }}</span>
                                </div>
                                <div class="bg-[#727272] text-[#727272] w-[1px] h-3 "></div>
                                <a class="text-[#727272]" href="">Add your Review</a>
                            </div>

                            <p class="text-[#727272] mb-6 text-sm">{{ product.description }}</p>
                            <div class="flex items-center mb-4">
                                <div class="text-red-700 text-lg font-semibold mr-2">${{ product.price }}</div>
                                <div class="text-gray-500 line-through mr-2">${{ product.old_price }}</div>
                                <div class="bg-red-600 text-white p-1 text-xs rounded">-{{ product.discount_percentage }}%</div>
                            </div>
                            <div class="font-semibold text-gray-800 mb-4 flex items-center gap-2 ">Availability :
                                <span class="text-gray-900 font-normal flex items-center">
                                    <svg width="15" height="15" aria-hidden="true" class="mr-1">
                                        <circle cx="7.5" cy="7.5" r="7.5" fill="rgb(62,214,96, 0.3)"></circle>
                                        <circle cx="7.5" cy="7.5" r="5" stroke="rgb(255, 255, 255)" stroke-width="1"
                                            fill="rgb(62,214,96)">
                                        </circle>
                                    </svg> {{ selectedStock }} in stock</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center mb-4">
                                <span class="mr-2 font-semibold text-gray-800 mb-2 sm:mb-0">Color:</span>
                                <div class="flex flex-wrap">
                                    <div v-for="color in colors" :key="color.name" class="inline-block mr-1 m-1">
                                        <button
                                            class="w-7 h-7 rounded-full p-0.5 flex items-center justify-center"
                                            @click="selectColor(color.name)"
                                            :style="{
                                                borderWidth: '2px',
                                                borderStyle: 'solid',
                                                borderColor: selectedColor === color.name ? color.hex : 'transparent'
                                            }"
                                        >
                                            <div
                                                class="w-full h-full rounded-full"
                                                :style="{ backgroundColor: color.hex }"
                                            ></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center mb-6">
                                <span class="font-semibold text-gray-800 pr-2 mb-2 sm:mb-0">Quantity: </span>
                                <div class="inline-flex items-center">
                                    <div class="flex border border-gray-300 rounded">
                                        <button @click="decrease"
                                            class="px-4 py-1 bg-white text-black rounded-l focus:outline-none">
                                            -
                                        </button>
                                        <span class="px-4 py-1 bg-white text-black border-l border-r border-gray-300 flex items-center justify-center min-w-[40px]">
                                            {{ quantity }}
                                        </span>
                                        <button @click="increase"
                                            class="px-4 py-1 bg-white text-black rounded-r focus:outline-none">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mt-8">
                                <button  class="w-full  px-2 py-2 bg-black text-white rounded hover:bg-gray-600">Add Wishlist</button>
                                <button @click="toggleCart"  class="w-full px-2 py-2 bg-black text-white rounded hover:bg-gray-600">Add To Cart</button>
                                <ShoppingCart v-if="cartVisible" @close="toggleCart" />
                                <button class="w-full  px-2 py-2 bg-red-700 text-white rounded hover:bg-orange-600">Buy Now</button>
                            </div>
                            <div class=" mt-4">

                            </div>
                        </div>
                    </div>
                    <!-- Tab Content -->
                    <div class="mt-16">
                        <!-- Mobile layout -->
                        <div class="flex flex-col sm:hidden">
                        <button class="tab-link" :class="{ 'active': activeTab === 'description' }" @click="activeTab = 'description'">Details</button>
                        <button class="tab-link mt-1" :class="{ 'active': activeTab === 'additional' }" @click="activeTab = 'additional'">More Information</button>
                        <button class="tab-link mt-1" :class="{ 'active': activeTab === 'reviews' }" @click="activeTab = 'reviews'">Reviews (1)</button>
                        <button class="tab-link mt-1">Custom Tabs</button>
                        </div>

                        <!-- Desktop layout -->
                        <div class="hidden sm:flex sm:justify-center tabs">
                        <button class="tab-link" :class="{ 'active': activeTab === 'description' }" @click="activeTab = 'description'">Details</button>
                        <button class="tab-link" :class="{ 'active': activeTab === 'reviews' }" @click="activeTab = 'reviews'">Reviews ({{ product.reviews.length }})</button>
                        </div>

                        <!-- Tab content -->
                        <div class="tab-content">
                        <div v-if="activeTab === 'description'">
                            <div class="product-details-wrapper">
    <div class="product-details ql-editor" v-html="productDetails"></div>
  </div>
                        </div>
                        <div v-if="activeTab === 'additional'">
                            <p>Additional information content...</p>
                        </div>
                        <div v-if="activeTab === 'reviews'">
                            <ProductReviews :productId="product.id" />
                        </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar -->
                <div class="col-span-1 md:col-span-12 lg:col-span-3">
                    <!-- Bestsellers -->
                    <div class="bg-white p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Bestsellers</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-1 gap-4">
                            <div v-for="item in bestsellers" :key="item.id" class="flex items-center">
                                <img :src="item.image" alt="Bestseller Image" class="w-16 h-16 mr-4 rounded-md border-[1px] py-1 border-gray-300" />
                                <div>
                                    <h3 class="text-gray-800">{{ item.name }}</h3>
                                    <div class="flex items-center">
                                        <span class="text-yellow-500">★★★★☆</span>
                                        <span class="ml-2 text-gray-600">{{ item.price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Advertisement -->
                    <div class="bg-white p-6">
                        <img src="http://magento2.magentech.com/themes/sm_gostore/pub/media/wysiwyg/banner/banner-sidebar.jpg" alt="Advertisement"
                            class="w-full" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref, reactive, computed, onMounted, watch } from 'vue';
import ShoppingCart from '../../../components/website/Cart/ShoppingCart.vue';
import Breadcrumb from '../../../components/website/Breadcrumbs/Breadcrumb.vue';
import axios from '../../../axios';
import { useRoute } from 'vue-router'
import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
import ProductReviews from './ProductReviews.vue';




const route = useRoute()




// State Management
const product = ref(null);
const currentImageIndex = ref(0);
const quantity = ref(1);
const selectedColor = ref('');
const cartVisible = ref(false);
const activeTab = ref('description');

const isArrowHovered = ref(false);
const productImage = ref(null);
const zoomResult = ref(null);
const isZoomed = ref(false);
const zoomStyle = reactive({
  backgroundImage: '',
  backgroundPosition: '0% 0%',
  backgroundSize: '',
});

const images = computed(() => product.value ? product.value.images.map(img => 'http://127.0.0.1:8000' + img.url) : []);
const colors = computed(() => product.value ? product.value.colors.map(color => ({ name: color, hex: getColorHex(color) })) : []);
const selectedStock = computed(() => product.value ? product.value.availability : 0);

const bestsellers = ref([
  { id: 1, name: 'Ascender Softshell Front-Zip', price: '$18.00', image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg' },
  { id: 2, name: 'Hiking Travel Outdoor', price: '$65.00', image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg' },
  { id: 3, name: 'Jerky Pork Bellygroud', price: '$38.00', image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg' },
  { id: 4, name: 'Khaki Button Tees Tees Blouses', price: '$200.00', image: 'https://ecommerce-ui.com/uikit/images/items/tech/1.jpg' },
]);


function convertDeltaToHtml(delta) {
  if (!delta) return '';

  let deltaOps;
  if (typeof delta === 'string') {
    try {
      deltaOps = JSON.parse(delta);
    } catch (error) {
      console.error('Error parsing delta:', error);
      return delta; // Return original content if parsing fails
    }
  } else {
    deltaOps = delta;
  }

  const converter = new QuillDeltaToHtmlConverter(deltaOps.ops, {});
  return converter.convert();
}

// Computed property for converted HTML
const productDetails = computed(() => {
  if (!product.value || !product.value.details) return '';
  return convertDeltaToHtml(product.value.details);
});

const getColorHex = (colorName) => {
  const colorMap = {
    pink: '#FFC0CB',
    red: '#FF0000',
    // Add more colors as needed
  };
  return colorMap[colorName.toLowerCase()] || '#000000';
};

const fetchProductData = async () => {
  try {
    const response = await axios.get(`/user/products/${route.params.slug}`);
    product.value = response.data;
    selectedColor.value = product.value.colors[0];
    updateZoomBackground(); // Update zoom background after fetching data
  } catch (error) {
    console.error('Error fetching product data:', error);
  }
};

// Computed Properties
const currentImage = computed(() => images.value[currentImageIndex.value]);

// Methods
function toggleCart() {
  cartVisible.value = !cartVisible.value;
}

function increase() {
  quantity.value++;
}

function decrease() {
  if (quantity.value > 1) {
    quantity.value--;
  }
}

function selectColor(color) {
  selectedColor.value = color;
  selectedStock.value = color === 'Coral' ? 10 : color === 'Blue' ? 5 : 0;
}

function setCurrentImage(index) {
  currentImageIndex.value = index;
}

function nextImage(event) {
  event.stopPropagation();
  currentImageIndex.value = (currentImageIndex.value + 1) % images.value.length;
}

function prevImage(event) {
  event.stopPropagation();
  currentImageIndex.value = (currentImageIndex.value - 1 + images.value.length) % images.value.length;
}

function handleMouseMove(event) {
  if (!productImage.value || !zoomResult.value || isArrowHovered.value) return;

  const { left, top, width, height } = productImage.value.getBoundingClientRect();
  const x = (event.clientX - left) / width * 100;
  const y = (event.clientY - top) / height * 100;

  zoomStyle.backgroundPosition = `${x}% ${y}%`;
  isZoomed.value = true;
}

function showZoom() {
  isArrowHovered.value = false;
}

function hideZoom() {
  isArrowHovered.value = true;
}

function handleMouseLeave() {
  isZoomed.value = false;
}

function updateZoomBackground() {
  if (images.value.length > 0) {
    zoomStyle.backgroundImage = `url(${images.value[currentImageIndex.value]})`;
    zoomStyle.backgroundSize = '180%';  // Adjust zoom level here
  }
}

// Lifecycle Hooks
onMounted(() => {
  fetchProductData();
});

watch(currentImageIndex, updateZoomBackground);
watch(() => product.value, updateZoomBackground);
</script>
<style scoped>


.arrow-area {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 15%;
    /* Adjust as needed */
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.left-arrow {
    left: 0;
}

.right-arrow {
    right: 0;
}

.arrow-button {
    background-color: rgba(255, 255, 255, 0.5);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.arrow-button:hover {
    background-color: rgba(255, 255, 255, 0.8);
}

.zoom-result {
    position: absolute;
    border: 1px solid #d4d4d4;
    width: 400px;
    height: 500px;
    top: 0;
    left: 100%;
    /* Position to the right of the main image */
    background-repeat: no-repeat;
    pointer-events: none;
    /* Prevents the zoom area from interfering with mouse events */
}
.tabs {
  color: #727272;
  border-bottom: 2px solid #ddd;
}
.tab-link {
  color: #727272;
  padding: 10px 20px;
  cursor: pointer;
  border-bottom: 2px solid transparent;
}
.tab-link.active {
  border-bottom: 4px solid red;
  color: red;
}
.tab-content {
  color: #727272;
  padding: 20px 0;
}

/* Additional styles for mobile layout */
@media (max-width: 640px) {
  .tab-link {
    width: 100%;
    text-align: left;
    padding: 10px 15px;
    border-bottom: none;
  }
}
@media (max-width: 768px) {
    .md\\:hidden {
        display: block;
    }
}
@media (min-width: 768px) {
    .md\\:hidden {
        display: none;
    }
}
</style>
