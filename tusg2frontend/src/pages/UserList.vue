<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { listUsers, deleteUser } from "@/services/user.js"


const users = ref([])
const loading = ref(true)
const error = ref('')
const router = useRouter()

// Load all users
async function load() {
  loading.value = true
  error.value = ''
  try {
    users.value = await listUsers()
  } catch {
    error.value = 'Could not load users.'
  } finally {
    loading.value = false
  }
}//

// Delete a user
async function onDelete(id) {
  const yes = confirm('Delete this user?')
  if (!yes) return

  try {
    await deleteUser(id)
    await load()
  } catch (err) {
    alert(err?.response?.data?.message ?? 'Delete failed')
  }
}

// Navigate to create form
function openCreate() {
  router.push('/users/new')
}

// Navigate to edit form
function openEdit(userID) {
  router.push(`/users/${userID}/edit`)
}

// Load users when component mounts
onMounted(load)
</script>


<template >
  <div class="dashboard-container">
    <section class="users-section">
      <div class="users-header">
        <h2>Manage Users</h2>
        <div>
          <button class="btn add" @click="openCreate">+ Add User</button>
          <button class="btn refresh" @click="load">Refresh</button>
        </div>
      </div>

      <div v-if="loading" class="state">Loading…</div>
      <div v-else-if="error" class="state error">{{ error }}</div>
      <div v-else-if="users.length === 0" class="state">No users found.</div>

      <table v-else class="users-table">
        <thead>
        <tr>
          <th style="width: 80px">#</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th style="width: 220px">Actions</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(user, index) in users" :key="user.userID">
          <td class="muted">{{ index + 1 }}</td>
          <td>{{ user.fname }}</td>
          <td>{{ user.lname }}</td>
          <td>{{ user.email }}</td>
          <td class="actions">
            <button class="btn view">View</button>
            <button class="btn update" @click="openEdit(user.userID)">Update</button>
            <button class="btn delete" @click="onDelete(user.userID)">Delete</button>
          </td>
        </tr>


        </tbody>
      </table>
    </section>
  </div>
</template>




<style scoped>

.dashboard-container{
  background: url("../images/BG.jpg");
  min-height: 60vh;

  padding: 1rem;

}
:root {
  --green: #4b8b3b;
  --green-d: #3d7a31;
  --red: #d9534f;
  --blue: #0275d8;
  --muted: #6b7280;
  --border: #e0e0e0;
}

.users-section {
  background: #fff9e0;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  margin: 2rem auto;
  max-width: 900px;
}

.users-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid var(--green);
  padding-bottom: 0.75rem;
  margin-bottom: 1rem;
}

.users-header h2 {
  margin: 0;
  color: #2f4f27;
  font-size: 1.4rem;
}

.btn {
  color: #fff;
  padding: 0.4rem 0.85rem;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.85rem;
  cursor: pointer;
  margin-left: 0.5rem;
}


.btn.add {
  background-color: #4b8b3b; /* green */
}
.btn.refresh {
  background-color: #0275d8; /* blue */
}

.btn.view {
  background-color: #0275d8;
}

.btn.update {
  background-color: green;
}

.btn.delete {
  background-color: red;
}

.users-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.95rem;
}

.users-table th,
.users-table td {
  border: 1px solid var(--border);
  padding: 0.75rem 1rem;
  text-align: left;
}

.users-table th {
  background-color: #e7f3e5;
  font-weight: 700;
  color: #2f4f27;
}

.users-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.actions {
  display: flex;
  gap: 0.5rem;
}

.muted {
  color: var(--muted);
}

.state {
  padding: 1rem;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 10px;
  text-align: center;
  color: #374151;
}

.state.error {
  border-color: #f0c2c2;
  color: #b91c1c;
}
</style>

