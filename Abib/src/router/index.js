// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    children: [
      {
        path: '',
        name: 'Home',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "home" */ '@/views/Login.vue'),
      },
    ],
  },
  {
    path: '/homepage',
    children: [
      {
        path: '',
        name: 'homepage',
        component: () => import(/* webpackChunkName: "homepage" */ '@/views/Homepage.vue'),
      }
    ]
  },
  {
    path: '/payment',
    children: [
      {
        path: '',
        name: 'payment',
        component: () => import(/* webpackChunkName: "homepage" */ '@/views/Payment.vue'),
      }
    ]
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
