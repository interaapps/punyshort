import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    meta: {
      hideSidebarContents: true
    },
    component: Home
  },
  {
    path: '/links/:id',
    name: 'Links',
    component: () => import('../views/dashboard/Link.vue')
  },
  {
    path: '/links',
    name: 'Links',
    component: () => import('../views/dashboard/Links.vue')
  },
  {
    path: '/:id',
    name: 'Link',
    component: () => import('../views/Link.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
