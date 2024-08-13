<template>
    <div>
      <h2 class="text-lg font-medium mb-6 text-gray-700">Customer Reviews</h2>

      <!-- Loading state -->
      <div v-if="loading" class="text-center text-gray-500 mb-8">Loading reviews...</div>

      <!-- Error state -->
      <div v-else-if="error" class="text-center text-red-500 mb-8">{{ error }}</div>

      <!-- Display existing reviews -->
      <div v-if="reviews?.length > 0" class="mb-8">
        <div v-for="review in reviews" :key="review.id" class="bg-white p-4 rounded-md shadow mb-4">
          <div class="flex items-center justify-between mb-2">
            <div class="flex items-center">
              <span class="text-md font-medium mr-2 text-gray-800">{{ review.user.name }}</span>
              <div class="flex">
                <svg v-for="star in 5" :key="star" :class="['w-4 h-4', star <= review.rating ? 'text-yellow-400' : 'text-gray-300']" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
            </div>
            <span class="text-sm text-gray-600">{{ formatDate(review.created_at) }}</span>
          </div>
          <p class="text-gray-600 text-sm">{{ review.comment }}</p>
        </div>
      </div>
      <div v-else class="text-center text-gray-500 mb-8">No reviews yet.</div>

      <div class="h-[1px] w-full bg-gray-300 mb-3"></div>
      <div class="h-[1px] w-full bg-gray-300 mb-5"></div>

      <!-- Add new review form -->
      <form v-if="isAuthenticated" @submit.prevent="submitReview" class="bg-white">
        <h3 class="text-lg font-medium mb-4 text-gray-700">Add Your Review</h3>
        <div class="mb-4">
          <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Your Rating*</label>
          <div class="flex">
            <button
              v-for="star in 5"
              :key="star"
              type="button"
              @click="newReview.rating = star"
              class="focus:outline-none"
            >
              <svg :class="['w-8 h-8', star <= newReview.rating ? 'text-yellow-400' : 'text-gray-300']" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
            </button>
          </div>
        </div>
        <div class="mb-4">
          <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Review*</label>
          <textarea
            id="comment"
            v-model="newReview.comment"
            rows="3"
            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:border-indigo-500"
            required
          ></textarea>
        </div>
        <button
          type="submit"
          class=" bg-black text-white py-2 px-4  hover:bg-indigo-700 transition duration-300 ease-in-out"
        >
          Submit Review
        </button>
      </form>

      <div v-else class="text-center text-gray-500 mt-8">Please log in to submit a review.</div>
    </div>
  </template>

  <script>
  import { useAuthStore } from '../../../stores/authStore'; // Adjust the path as needed
  import { ref, computed } from 'vue';
  import axios from '../../../axios';

  export default {
    name: 'ProductReviews',
    props: {
      productId: {
        type: Number,
        required: true
      }
    },
    setup(props) {
      const authStore = useAuthStore();
      const isAuthenticated = computed(() => authStore.isAuthenticated);

      const reviews = ref([]);
      const newReview = ref({
        rating: 0,
        comment: ''
      });
      const loading = ref(true);
      const error = ref(null);

      const fetchReviews = async () => {
        try {
          loading.value = true;
          error.value = null;
          const response = await axios.get(`/user/products/${props.productId}/reviews`);
          reviews.value = response.data;
        } catch (err) {
          console.error('Error fetching reviews:', err);
          error.value = 'Failed to load reviews. Please try again later.';
        } finally {
          loading.value = false;
        }
      };

      const submitReview = async () => {
        try {
            console.log(newReview.value)
          const response = await axios.post(`/user/products/${props.productId}/reviews`, newReview.value);
          reviews.value.unshift(response.data);
          newReview.value = { rating: 0, comment: '' };
        } catch (err) {
          console.error('Error submitting review:', err);
          error.value = 'Failed to submit review. Please try again later.';
        }
      };

      const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
      };

      // Fetch reviews when the component is mounted
      fetchReviews();

      return {
        reviews,
        newReview,
        submitReview,
        formatDate,
        loading,
        error,
        isAuthenticated
      };
    }
  };
  </script>
