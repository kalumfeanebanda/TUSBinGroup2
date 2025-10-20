import { createRouter, createWebHistory } from 'vue-router'



import Home from './pages/Home.vue'
import Login from './pages/UserLogin.vue'
import Register from './pages/UserRegister.vue'
import AdminLogin from './pages/AdminLogin.vue'
import AdminDashboard from './pages/AdminDashboard.vue'

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/adminlogin', name: 'adminlogin', component: AdminLogin },
    { path: '/admindashboard', name: 'admindashboard', component: AdminDashboard }

import Home from './pages/Home.vue'
import Login from "./pages/Login.vue";
import Register from "./pages/Register.vue"
import AdminDashboard from "./pages/AdminDashboard.vue";
const routes = [
    { path: '/', name: 'home', component: Home },
    {path: '/login', name: 'login',component: Login},
    {path: '/register',name:'register',component: Register},
    {path: '/Admindashboard', name: 'admindashboard', component: AdminDashboard}

]

export const router = createRouter({
    history: createWebHistory(),
    routes
})

