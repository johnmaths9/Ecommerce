<template>
    <div class="mx-auto max-w-screen-2xl p-4 my-6">
        <div class="mb-8">
            <h1 class="text-4xl font-semibold text-gray-800">Checkout</h1>
        </div>
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-2/3 order-2 md:order-1">
                <div class="mb-6 border-b pb-4">
                    <div class="flex justify-between items-center cursor-pointer" @click="toggleAccountDropdown">
                        <h2 class="text-xl font-semibold text-gray-800">Account</h2>
                        <svg :class="{ 'rotate-180': isAccountDropdownOpen }"
                            class="w-5 h-5 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <transition name="fade">
                        <div v-if="isAccountDropdownOpen" class="mt-4">
                            <p class="mb-2">{{ user?.email }}</p>
                            <a href="#" @click.prevent="logout" class="text-green-600 hover:underline">Log out</a>
                        </div>
                    </transition>
                </div>

                <!-- Delivery Section -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Delivery</h2>
                    <div class="mb-4">
                        <label class="block mb-2 text-gray-800 text-sm">Country/Region</label>
                        <select v-model="country" class="w-full border p-2 rounded text-gray-800 text-sm">
                            <option value="Morocco">Morocco</option>
                        </select>
                    </div>
                    <div class="flex gap-4 mb-4">
                        <div class="w-1/2">
                            <label class="block mb-2 text-sm text-gray-800">First name (optional)</label>
                            <input v-model="firstName" type="text" class="w-full border p-2 rounded text-sm">
                        </div>
                        <div class="w-1/2">
                            <label class="block mb-2 text-sm text-gray-800">Last name</label>
                            <input v-model="lastName" type="text" class="w-full border p-2 rounded text-sm">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm text-gray-800">Address</label>
                        <input v-model="address" type="text" class="w-full border p-2 rounded text-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm text-gray-800">Apartment, suite, etc. (optional)</label>
                        <input v-model="apartment" type="text" class="w-full border p-2 rounded text-sm">
                    </div>
                    <div class="flex gap-4 mb-4 text-gray-800">
                        <div class="w-1/2">
                            <label class="block mb-2 text-sm text-gray-800">Postal code (optional)</label>
                            <input v-model="postalCode" type="text" class="w-full border p-2 rounded text-sm">
                        </div>
                        <div class="w-1/2">
                            <label class="block mb-2 text-sm text-gray-800">City</label>
                            <input v-model="city" type="text" class="w-full border p-2 rounded text-sm">
                        </div>
                    </div>
                </div>

                <!-- Shipping Method Section -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Shipping method</h2>
                    <div class="border p-3 rounded flex justify-between items-center text-gray-800">
                        <span>Standard</span>
                        <span>$17.91</span>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-2 flex items-center">Payment Method</h2>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" v-model="paymentMethod" value="paypal" class="mr-2">
                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg"
                                alt="PayPal" class="h-6 mr-2">
                            Pay with PayPal
                        </label>
                        <label class="flex items-center">
                            <input type="radio" v-model="paymentMethod" value="card" class="mr-2">
                            Pay with credit or debit card
                        </label>
                    </div>
                    <div v-if="paymentMethod === 'paypal'" class="mt-4">
                        <div id="paypal-button-container"></div>
                    </div>
                    <div v-if="paymentMethod === 'card'" class="mt-4 space-y-2">
                        <input type="text" v-model="cardNumber" placeholder="Card Number"
                            class="w-full p-2 border rounded text-sm">
                        <div class="flex space-x-2">
                            <input type="text" v-model="expiryMonth" placeholder="MM"
                                class="w-1/4 p-2 border rounded text-sm">
                            <input type="text" v-model="expiryYear" placeholder="YY"
                                class="w-1/4 p-2 border rounded text-sm">
                            <input type="text" v-model="cvv" placeholder="CVV/CVC"
                                class="w-1/2 p-2 border rounded text-sm">
                        </div>
                        <div class="flex space-x-2">
                            <input type="text" v-model="cardFirstName" placeholder="First Name"
                                class="w-1/2 p-2 border rounded text-sm">
                            <input type="text" v-model="cardLastName" placeholder="Last Name"
                                class="w-1/2 p-2 border rounded text-sm">
                        </div>
                    </div>
                </div>

                <button @click="placeOrder"
                    class="w-full bg-gray-600 text-white py-3 rounded-md text-sm font-semibold mt-4">
                    Place Order
                </button>
            </div>

            <!-- Cart Summary Section -->
            <div class="w-full md:w-1/3 order-1 md:order-2">
                <div class="bg-gray-100 p-4 rounded">
                    <div v-for="item in cartItems" :key="item.product_id" class="flex items-center mb-4 border-b-2 border-gray-200">
                        <div class="relative mr-4 ">
                            <img :src="`http://127.0.0.1:8000${item.image}`" :alt="item.name" class="w-16 h-16 object-cover">
                            <span
                                class="absolute -top-2 -right-2 bg-gray-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                {{ item.quantity }}
                            </span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700">{{ item.name }}</h3>
                            <p class="text-sm text-gray-600">{{ item.description }}</p>
                        </div>
                        <span class="ml-auto">${{ item.price }}</span>
                    </div>

                    <div class="flex mb-4">
                        <input type="text" placeholder="Discount code" class="flex-grow border p-2 rounded-l">
                        <button class="bg-gray-200 px-4 py-2 rounded-r">Apply</button>
                    </div>

                    <div class="border-t pt-4 text-gray-800">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ cartTotal.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Shipping</span>
                            <span>${{ shipping.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between font-semibold">
                            <span>Total</span>
                            <span>USD ${{ total.toFixed(2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 md:hidden">
            <button class="w-full bg-blue-600 text-white py-3 rounded">Pay now</button>
        </div>

        <div class="mt-6 hidden md:block">
            <button class="w-2/3 bg-blue-600 text-white py-3 rounded">Pay now</button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useCartStore } from '../../../stores/cartStore';
import { useAuthStore } from '../../../stores/authStore';

const cartStore = useCartStore();
const authStore = useAuthStore();

const isAccountDropdownOpen = ref(false);

const user = computed(() => authStore.user);
const logout = () => {
    authStore.logout();
};

const country = ref('Morocco');
const firstName = ref('');
const lastName = ref('');
const address = ref('');
const apartment = ref('');
const postalCode = ref('');
const city = ref('');
const paymentMethod = ref('paypal');
const cardNumber = ref('');
const expiryMonth = ref('');
const expiryYear = ref('');
const cvv = ref('');
const cardFirstName = ref('');
const cardLastName = ref('');

// Example cart items (replace with actual data)
const cartItems = computed(() => cartStore.items);
const cartTotal = computed(() => cartStore.cartTotal);

// Shipping cost
const shipping = ref(17.91);

// Calculate total
const total = computed(() => cartTotal.value + shipping.value);



const placeOrder = () => {
    if (paymentMethod.value === 'paypal') {
        console.log('Placing order with PayPal');
    } else {
        console.log('Placing order with card', {
            cardNumber: cardNumber.value,
            expiry: `${expiryMonth.value}/${expiryYear.value}`,
            cvv: cvv.value,
            name: `${firstName.value} ${lastName.value}`
        });
    }
};

onMounted(() => {
    if (window.paypal) {
        window.paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '17.91' // Replace with the actual amount
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    console.log('Transaction completed by ' + details.payer.name.given_name);
                    placeOrder();
                });
            }
        }).render('#paypal-button-container');
    }
});
onMounted(() => {
    cartStore.fetchCart();
    console.log(cartStore.items);

});
const toggleAccountDropdown = () => {
    isAccountDropdownOpen.value = !isAccountDropdownOpen.value;
};




const subtotal = computed(() => {
    return products.value.reduce((sum, product) => sum + product.price * product.quantity, 0);
});

</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
