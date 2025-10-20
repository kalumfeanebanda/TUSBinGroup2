import { createRouter, createWebHistory } from 'vue-router'
import Home from './pages/Home.vue'
import Login from "./pages/UserLogin.vue";
import Register from "./pages/UserRegister.vue"
const routes = [
    { path: '/', name: 'home', component: Home },
    {path: '/login', name: 'login',component: Login},
    {path: '/register',name:'register',component: Register}
]

export const router = createRouter({
    history: createWebHistory(),
    routes
})