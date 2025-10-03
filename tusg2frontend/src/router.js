import { createRouter, createWebHistory } from 'vue-router'
import home from './pages/home.vue'
import signin from "./pages/signin.vue";
import signup from "./pages/signup.vue";
import AdminDashboard from "@/pages/AdminDashboard.vue";





const routes = [
    { path: '/', name: 'home', component: home },
    // { path: '/login', name: 'login', component: () => import('../pages/LoginPage.vue') }
    {path: '/signin', name: 'signin',component: signin},
    {path: '/signup',name:'signup',component: signup},
    {path: '/Admindashboard', name: 'admindashboard', component: AdminDashboard}

]

export const router = createRouter({
    history: createWebHistory(),
    routes
})