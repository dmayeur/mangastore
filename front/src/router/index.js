import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    meta: {
      title: 'Accueil',
      description: "Bienvenue sur MangaStore ! Le site spécialisé en vente de manga. "
    },
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
},
{
      path: '/catalogue',
      name: 'Catalog',
      meta: {
        title: 'Catalogue'
      },
      component: () => import('../views/Catalog.vue')
},
{
    path: '/serie/:id',
    name: 'Serie',
    meta: {
      title: 'Serie'
    },
    component: () => import('../views/Serie.vue')
},
{
    path: '/contact',
    name: 'Contact',
    meta: {
      title: 'Contact'
    },
    component: () => import('../views/Contact.vue')
},
{
    path: '/inscription',
    name: 'Signup',
    meta: {
      title: 'Inscription'
    },
    component: () => import('../views/Signup.vue')
},
{
    path: '/panier',
    name: 'Cart',
    meta: {
        title: 'Mon panier'
    },
    component: () => import('../views/Cart.vue')
},

/* ===================================================
                CRUD ROUTES
================================================== */
{
    path: '/admin/series',
    name: 'AdminSeries',
    meta: {
      title: 'Admin - Series'
    },
    component: () => import('../admin/Admin.vue')
},
{
    path: '/admin/series/:id',
    name: 'AdminSeriesModify',
    meta: {
      title: 'Admin'
    },
    component: () => import('../admin/Admin.vue')
},
{
    path: '/admin/series/create',
    name: 'AdminSeriesCreate',
    meta: {
      title: 'Admin'
    },
    component: () => import('../admin/create/createSerie.vue')
},
{
    path: '/admin/editeurs',
    name: 'AdminEditors',
    meta: {
      title: 'Admin'
    },
    component: () => import('../admin/Admin.vue')
},
{
    path: '/admin/editeurs/:id',
    name: 'AdminEditorsModify',
    meta: {
      title: 'Admin'
    },
    component: () => import('../admin/Admin.vue')
},
{
    path: '/admin/categories',
    name: 'AdminCategories',
    meta: {
      title: 'Admin - Categories'
    },
    component: () => import('../admin/Admin.vue')
},
{
    path: '/admin/auteurs',
    name: 'AdminAuthors',
    meta: {
      title: 'Admin - Auteurs'
    },
    component: () => import('../admin/Admin.vue')
}
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
