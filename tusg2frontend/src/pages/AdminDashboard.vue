
<template>
  <div class="dashboard">
    <!-- Side Nav -->
    <aside class="sidebar">
      <ul>
        <li @click="goTo('steps')" :class="{ active: activeTab === 'steps' }">Steps</li>
        <li @click="goTo('items')" :class="{ active: activeTab === 'items' }">Items</li>
        <li @click="goTo('user')" :class="{ active: activeTab === 'user' }">User</li>
        <li @click="goTo('staff')" :class="{ active: activeTab === 'staff' }">Staff</li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <h2>Welcome To Admin Dashboard</h2>
      <div class="cards">
        <button class="card items-card">Items</button>
        <button class="card bins-card">Bins</button>
        <button class="card location-card">Location</button>
      </div>
    </main>
  </div>







</template>

<script setup>
import { ref } from 'vue'
import { useRouter} from "vue-router";

const router = useRouter()
const activeTab = ref('steps')

function goTo(tab) {
  activeTab.value = tab
  router.push(`/${tab}`)}



</script>


<style scoped>

.dashboard {
  display: flex;
  height: 100%;
}

/* Sidebar */
.sidebar {
  width: 200px;
  background: #3ca35c;
  padding-top: 20px;
}
.sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.sidebar li {
  padding: 12px 20px;
  cursor: pointer;
  color: #fff;
  font-weight: 500;
  transition: 0.3s;
}
.sidebar li:hover {
  background: #2d7a45;
}
.sidebar li.active {
  background: #256b3b;
}

/* Main Content */
.content {
  flex: 1;
  padding: 30px;
  text-align: center;
}
.content h2 {
  margin-bottom: 30px;
  font-weight: bold;
  color: #222;
}

/* Cards */
.cards {
  display: flex;
  justify-content: center;
  gap: 20px;
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
</style>