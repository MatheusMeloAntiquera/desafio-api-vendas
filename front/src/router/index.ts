import { createRouter, createWebHistory } from 'vue-router'
import VendedoresView from '../views/VendedoresView.vue'
import VendedorNovo from '../views/VendedorNovo.vue'
import VendedorVendas from '../views/VendedorVendas.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'vendedores',
      component: VendedoresView
    },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue')
    // },
    {
      path: '/vendedor/novo',
      name: 'vendedor.novo',
      component: VendedorNovo
    },
    {
      path: '/vendedor/:id/vendas',
      name: 'vendedor.vendas',
      component: VendedorVendas
    },
  ]
})

export default router
