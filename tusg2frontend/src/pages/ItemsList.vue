<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { listItems, deleteItem, createItem, updateItem } from '@/services/items.js'

const router = useRouter()
const items = ref([])
const loading = ref(true)
const error = ref('')
const showForm = ref(false)
const editing = ref(null)
const form = ref({ itemName: '', itemDesc: '' })

async function load() {
  loading.value = true
  error.value = ''
  try {
    items.value = await listItems()
  } catch {
    error.value = "Couldn't load items"
  } finally {
    loading.value = false
  }
}

function openCreate() {
  showForm.value = true
  editing.value = null
  form.value = { itemName: '', itemDesc: '' }
}

function openEdit(item) {
  showForm.value = true
  editing.value = item
  form.value = { itemName: item.itemName, itemDesc: item.itemDesc }
}

function cancel() {
  showForm.value = false
  editing.value = null
  form.value = { itemName: '', itemDesc: '' }
}

async function save() {
  try {
    if (!form.value.itemName) return alert("Item name required")

    if (editing.value) {
      await updateItem(editing.value.itemID, form.value)
      alert("Item updated!")
    } else {
      await createItem(form.value)
      alert("Item created!")
    }

    cancel()
    await load()
  } catch (err) {
    alert(err?.response?.data?.message || "Error saving item")
  }
}

async function remove(id) {
  if (!confirm("Delete this item?")) return
  await deleteItem(id)
  await load()
}

onMounted(load)
</script>


<template>
  <div class="dashboard-container">

    <!-- Navbar -->
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
      </nav>
    </header>

    <div class="main-content">

      <!-- Sidebar -->
      <aside class="sidebar">
        <ul>
          <li @click="router.push('/admindashboard')">Steps</li>
          <li class="active">Items</li>
          <li @click="router.push('/bins')">Bins</li>
          <li @click="router.push('/users')">Users</li>
          <li>Staff</li>
        </ul>
      </aside>

      <!-- Items Section -->
      <main class="content">
        <section class="items-section">
          <div class="items-header">
            <button class="btn back" @click="router.push('/admindashboard')">
              ⬅ Back to Admin Dashboard
            </button>

            <h2>Manage Items</h2>
            <div class="controls">
              <button class="btn add" @click="openCreate">Create Item</button>
              <button class="btn refresh" @click="load">Refresh</button>
            </div>
          </div>

          <!-- Form -->
          <div v-if="showForm" class="item-form">
            <h3>{{ editing ? 'Update Item' : 'Create New Item' }}</h3>

            <div class="form-row">
              <label>Item Name:</label>
              <input v-model="form.itemName" placeholder="Enter item name" />
            </div>

            <div class="form-row">
              <label>Description:</label>
              <input v-model="form.itemDesc" placeholder="Enter description" />
            </div>

            <div class="form-actions">
              <button class="btn create" @click="save">
                {{ editing ? 'Update Item' : 'Create Item' }}
              </button>
              <button class="btn cancel" @click="cancel">Cancel</button>
            </div>
          </div>

          <div v-if="loading" class="state">Loading…</div>
          <div v-else-if="error" class="state error">{{ error }}</div>
          <div v-else-if="items.length === 0" class="state">No items found.</div>

          <table v-else class="items-table">
            <thead>
            <tr>
              <th>#</th>
              <th>Item Name</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="i in items" :key="i.itemID">
              <td class="muted">{{ i.itemID }}</td>
              <td>{{ i.itemName }}</td>
              <td>{{ i.itemDesc }}</td>
              <td class="actions">
                <button class="btn update" @click="openEdit(i)">Update</button>
                <button class="btn delete" @click="remove(i.itemID)">Delete</button>
              </td>
            </tr>
            </tbody>
          </table>
        </section>
      </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <p><strong>Contact Us</strong></p>
      <p>Technological University of Shannon</p>
      <p>support@tusbinright.tus.ie | (087) 066 0662</p>
      <p>© 2025 TUSBinRight++. All rights reserved. Developed by Group 2</p>
    </footer>

  </div>
</template>


<style scoped>
:root {
  --green: #4b8b3b;
  --green-d: #3d7a31;
  --red: #d9534f;
  --muted: #6b7280;
  --border: #e0e0e0;
}

/* ---- ADMIN WRAPPER UI ---- */
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

.nav-links a {
  color: white;
  text-decoration: none;
  margin-left: 1.25rem;
  font-weight: bold;
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
}

.sidebar li.active {
  background: #256b3b;
}

.content {
  flex: 1;
  padding: 30px;
}

/* ---- ORIGINAL ITEMS CSS ---- */

.items-section {
  background: #fff;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  margin: 1rem auto;
  max-width: 900px;
}

.items-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid var(--green);
  padding-bottom: 0.75rem;
  margin-bottom: 1rem;
}

.controls {
  display: flex;
  gap: 0.5rem;
}

.btn {
  color: #fff;
  padding: 0.4rem 0.85rem;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
}

.btn.add {
  background-color: pink;
  color: #000;
  font-weight: 600;
}

.btn.add:hover {
  background-color: #ffb6c1;
}

.btn.refresh {
  background-color: pink;
  color: #000;
  font-weight: 600;
}

.btn.refresh:hover {
  background-color: #ffb6c1;
}
.btn.update {
  background-color: pink;
  color: #000;
  font-weight: 600;
}

.btn.update:hover {
  background-color: #ffb6c1;
}

.btn.delete {
  background-color: pink;
  color: #000;
  font-weight: 600;
}

.btn.delete:hover {
  background-color: #ffb6c1;
}
.btn.create {
  background-color: pink;
  color: #000;
  font-weight: 600;
}

.btn.create:hover {
  background-color: #ffb6c1;
}
.btn.cancel {
  background-color: pink;
  color: #000;
  font-weight: 600;
}

.btn.cancel:hover {
  background-color: #ffb6c1;
}

.btn.back { background: #0275d8; }

.items-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.95rem;
}

.items-table th,
.items-table td {
  border: 1px solid var(--border);
  padding: 0.75rem 1rem;
}

.items-table th {
  background-color: #e7f3e5;
  font-weight: 700;
}

.item-form {
  background: #f9f9f9;
  padding: 1rem;
  border: 1px solid var(--border);
  border-radius: 8px;
  margin-bottom: 1rem;
}

.form-row {
  margin-bottom: 0.75rem;
}

.state {
  padding: 1rem;
  border: 1px solid var(--border);
  border-radius: 10px;
  text-align: center;
}

.state.error {
  color: #b91c1c;
}

.muted {
  color: var(--muted);
}

/* Footer */
.footer {
  background-color: #2e7d32;
  color: white;
  text-align: center;
  padding: 1rem;
  border-top: 3px solid #1b5e20;
}
</style>
