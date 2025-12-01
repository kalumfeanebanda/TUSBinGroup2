<template>
  <div class="dashboard-container">
    <header class="navbar">
      <div class="logo-section">
        <img src="@/assets/recycle.jpg" alt="TUSBinRight++" class="logo" />
        <h1 class="title-text">TUSBinRight++</h1>
      </div>

      <nav class="nav-links">
        <router-link to="/">Home</router-link>
        <router-link to="/users">User</router-link>
        <router-link to="/admin">Admin</router-link>
        <router-link to="/menu">Menu</router-link>
        <router-link to="/adminlogin">Logout</router-link>
        <router-link to="/steps">Steps</router-link>
      </nav>
    </header>


    <div class="main-content">
      <aside class="sidebar">
        <ul>
          <li @click="goTo('steps')" :class="{ active: activeTab === 'steps' }">Steps</li>
          <li @click="goTo('items')" :class="{ active: activeTab === 'items' }">Items</li>
          <li @click="goTo('users')" :class="{ active: activeTab === 'users' }">User</li>
          <li @click="goTo('staff')" :class="{ active: activeTab === 'staff' }">Staff</li>
          <li @click="goTo('itembin')" :class="{ active: activeTab === 'itembin' }">itembin</li>
          <li @click="goTo('itemcodes')" :class="{ active: activeTab === 'itemcodes' }">Barcodes</li>
        </ul>
      </aside>


      <main class="content">
        <h2>Welcome To Admin Dashboard</h2>
        <div class="cards">
          <RouterLink to="/items" class="card items-card">Items</RouterLink>
          <RouterLink to="/bins" class="card bins-card">Bins</RouterLink>
          <RouterLink to="/itemcodes"  class="card itemcodes-card">Barcodes</RouterLink>
          <button class="card location-card">Location</button>
        </div>
      </main>
    </div>


    <footer class="footer">
      <div>
        <p><strong>Contact Us</strong></p>
        <p>Technological University of Shannon</p>
        <p>support@tusbinright.tus.ie | (087) 066 0662</p>
      </div>
      <div>
        <p>© 2025 TUSBinRight++. All rights reserved.</p>
        <p>Developed by Group 2</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const activeTab = ref('steps')

function goTo(tab) {
  activeTab.value = tab
  console.log(`Navigated to ${tab}`)
  router.push('/' + tab)
}
</script>

<style scoped>
.dashboard-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: #fff6f6;
}


.navbar {
  background-color: #4caf50;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 2rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.logo-section {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.logo {
  width: 45px;
  border-radius: 50%;
}

.title-text {
  font-size: 1.4rem;
  font-weight: bold;
  letter-spacing: 0.5px;
}

.nav-links a {
  color: white;
  text-decoration: none;
  margin-left: 1.25rem;
  font-weight: bold;
  transition: 0.3s;
}

.nav-links a:hover {
  text-decoration: underline;
  color: #e8f5e9;
}


.main-content {
  display: flex;
  flex: 1;
}


.sidebar {
  width: 220px;
  background: #388e3c;
  padding-top: 20px;
  color: #fff;
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sidebar li {
  background-color: #66bb6a;
  margin: 10px 15px;
  padding: 0.9rem;
  text-align: center;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
}

.sidebar li:hover {
  background: #2e7d32;
}

.sidebar li.active {
  background: #256b3b;
}


.content {
  flex: 1;
  padding: 30px;
  text-align: center;
}

.content h2 {
  margin-bottom: 30px;
  font-weight: bold;
  color: #1b5e20;
}

.cards {
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
}


.card {
  flex: 1;
  max-width: 200px;
  padding: 40px 0;
  border-radius: 12px;
  font-size: 18px;
  font-weight: bold;
  color: #fff;
  border: none;
  cursor: pointer;
  transition: transform 0.2s, opacity 0.2s;
}

.card:hover {
  transform: translateY(-5px);
  opacity: 0.9;
}

.items-card {
  background: #a2c94d;
}

.bins-card {
  background: #4cc97f;
}

.location-card {
  background: #4db8c9;
}


.footer {
  background-color: #2e7d32;
  color: white;
  text-align: center;
  padding: 1rem;
  font-size: 0.9rem;
  border-top: 3px solid #1b5e20;
}

.footer p {
  margin: 0.2rem 0;
}


@media (max-width: 768px) {
  .main-content {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    text-align: center;
  }

  .cards {
    flex-direction: column;
    align-items: center;
  }
}
</style>


