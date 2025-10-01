import { createRouter, createWebHistory } from 'vue-router'
import home from './pages/home.vue'
import login from "@/pages/Login.vue";
import register from "@/pages/Register.vue"
const routes = [
    { path: '/', name: 'home', component: home },
    {path: '/Login', name: 'login',component: login},
    {path: '/Register',name:'register',component: register}
]

export const router = createRouter({
    history: createWebHistory(),
    routes
})