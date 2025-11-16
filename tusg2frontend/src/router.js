import { createRouter, createWebHistory } from 'vue-router'

import Home from './pages/Home.vue'
import Login from './pages/UserLogin.vue'
import Register from './pages/UserRegister.vue'
import AdminLogin from './pages/AdminLogin.vue'
import AdminDashboard from './pages/AdminDashboard.vue'
import SearchItems from './pages/SearchItems.vue'


const routes = [
    { path: '/', name: 'home', component: Home },

    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/adminlogin', name: 'adminlogin', component: AdminLogin },
    { path: '/admindashboard', name: 'admindashboard', component: AdminDashboard },

    { path: '/search-items', name: 'search-items', component: SearchItems },

    { path: '/logged-in-home', name: 'logged-in-home', component: () => import('@/pages/LoggedInHome.vue') },

    { path: '/steps', name: 'steps', component: () => import('@/pages/Steps.vue') },
    { path: '/items', name: 'items', component: () => import('@/pages/ItemsList.vue') },
    { path: '/bins', name: 'bins', component: () => import('@/pages/BinsList.vue') },
    { path: '/users', name: 'users', component: () => import('@/pages/UserList.vue') },



    { path: '/item-result', name: 'item-result', component: () => import('@/pages/ItemResult.vue') },

    { path: '/users/new', name: 'user-create', component: () => import('@/pages/UserForm.vue') },
    { path: '/users/:id/edit', name: 'user-edit', component: () => import('@/pages/UserForm.vue') }
]


export const router = createRouter({
    history: createWebHistory(),
    routes
})


