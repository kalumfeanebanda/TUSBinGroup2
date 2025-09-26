import { createRouter, createWebHistory } from 'vue-router'
import home from './pages/home.vue'

const routes = [
    { path: '/', name: 'home', component: home },
    // { path: '/login', name: 'login', component: () => import('../pages/LoginPage.vue') }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
})