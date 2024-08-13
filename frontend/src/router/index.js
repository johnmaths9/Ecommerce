import { createRouter, createWebHistory } from 'vue-router';
import AuthLayout from '../layouts/AuthLayout.vue';
import Login from '../components/auth/LoginForm.vue';
import Signup from '../components/auth/RegisterForm.vue';
import AdminLayout from '../layouts/AdminLayout.vue';
import Products from '../pages/admin/Products/Products.vue';
import AddProduct from '../pages/admin/Products/Add.vue';
import Dashboard from '../pages/admin/Dashboard.vue';
import Categories from '../pages/admin/categories/Categories.vue';
import Orders from '../pages/admin/Orders/Orders.vue';
import Users from '../pages/admin/Users/Users.vue';
import Customers from '../pages/admin/Customers/Customers.vue';
import Product from '../pages/Website/Product/Product.vue';
import Home from '../pages/Website/Home/Home.vue';
import DefaultLayout from '../layouts/DefaultLayout.vue';
import Wishlist from '../pages/Website/Wishlist/Wishlist.vue';
import Checkout from '../pages/Website/chekout/checkout.vue';
import Edit from '../pages/admin/Products/Edit.vue';



const routes = [
    {
        path: '/',
        component: DefaultLayout,
        children:[
            {
                path: '/',
                component: Home,
            },
            {
                path: '/product/:slug',
                component: Product,
            },
            {
                path: '/wishlist',
                component: Wishlist,
            },
            {
                path: '/checkout',
                component: Checkout,
            },
        ]
    },
    {
        path: '/',
        component: AdminLayout,
        children: [
            {
                path: '/dashboard',
                component: Dashboard,
            },
            {
                path: '/customers',
                component: Customers,
            },
            {
                path: '/users',
                component: Users,
            },
            {
                path: '/categories',
                component: Categories,
            },
            {
                path: '/orders',
                component: Orders,
            },
            {
              path: '/products/all',
              component: Products,
            },
            {
                path: '/products/edit/:id',
                component: Edit,
            },
            {
                path: '/products/add',
                component: AddProduct,
              },

          ],
    },
    {
        path: '/',
        component: AuthLayout,
        children: [
          {
            path: 'login',
            component: Login,
          },
          {
            path: 'signup',
            component: Signup,
          },

        ],
      },
  ];








  const router = createRouter({
    history: createWebHistory(),
    routes,
  });

  export default router;
