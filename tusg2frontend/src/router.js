import { createRouter, createWebHistory } from 'vue-router'


import Home from './pages/Home.vue'
import Login from "./pages/UserLogin.vue"
import Register from "./pages/UserRegister.vue"


import AdminLogin from "./pages/AdminLogin.vue"
import AdminDashboard from "./pages/AdminDashboard.vue"

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },


    { path: '/admin login', name: 'admin login', component: AdminLogin },
    { path: '/admin dashboard', name: 'admin dashboard', component: AdminDashboard },
]

export const router = createRouter({
    history: createWebHistory(),
    routes
})
