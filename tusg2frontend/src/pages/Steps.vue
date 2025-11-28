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
      </nav>
    </header>

    <div class="main-content">

      <aside class="sidebar">
        <ul>
          <li class="active">Steps</li>
          <li @click="router.push('/items')">Items</li>
          <li @click="router.push('/bins')">Bins</li>
        </ul>
      </aside>

      <main class="content">
        <section class="steps-section">
          <div class="steps-header">
            <button class="btn back" @click="router.push('/admindashboard')">
              ⬅ Back to Admin Dashboard
            </button>

            <h2>Manage Steps</h2>
            <div class="controls">
              <button class="btn add" @click="openCreate">Create Step</button>
              <button class="btn refresh" @click="load">Refresh</button>
            </div>
          </div>

          <!-- FORM -->
          <div v-if="showForm" class="step-form">
            <h3>{{ editing ? 'Update Step' : 'Create New Step' }}</h3>

            <div class="form-row">
              <label>Item Code ID:</label>
              <input v-model="form.itemCodeID" type="number" />
            </div>

            <div class="form-row">
              <label>Step Title:</label>
              <input v-model="form.stepTitle" />
            </div>

            <div class="form-row">
              <label>Long Description:</label>
              <textarea v-model="form.stepLongDesc" rows="3"></textarea>
            </div>

            <div class="form-actions">
              <button class="btn create" @click="save">
                {{ editing ? 'Update Step' : 'Create Step' }}
              </button>
              <button class="btn cancel" @click="cancel">Cancel</button>
            </div>
          </div>

          <div v-if="loading" class="state">Loading…</div>
          <div v-else-if="error" class="state error">{{ error }}</div>
          <div v-else-if="steps.length === 0" class="state">No steps found.</div>

          <!-- TABLE -->
          <table v-else class="steps-table">
            <thead>
            <tr>
              <th>prepStepID</th>
              <th>itemCodeID</th>
              <th>stepOrder</th>
              <th>Step Title</th>
              <th>Long Description</th>
              <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="i in steps" :key="i.prepStepID">
              <td class="muted">{{ i.prepStepID }}</td>
              <td class="muted">{{ i.itemCodeID }}</td>
              <td class="muted">{{ i.stepOrder }}</td>
              <td>{{ i.stepTitle }}</td>
              <td>{{ i.stepLongDesc }}</td>

              <td class="actions">
                <button class="btn update" @click="openEdit(i)">Update</button>
                <button class="btn delete" @click="remove(i.prepStepID)">Delete</button>
              </td>
            </tr>
            </tbody>
          </table>

        </section>
      </main>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { listSteps, deleteStep, createStep, updateStep } from '@/services/steps.js'

const router = useRouter()

const steps = ref([])
const loading = ref(true)
const error = ref('')

const showForm = ref(false)
const editing = ref(null)

const form = ref({
  itemCodeID: '',
  stepTitle: '',
  stepLongDesc: ''
})

async function load() {
  loading.value = true
  try {
    steps.value = await listSteps()
  } catch (err) {
    error.value = err?.message || "Couldn't load steps"
  }
  loading.value = false
}

function openCreate() {
  showForm.value = true
  editing.value = null
  form.value = { itemCodeID: '', stepTitle: '', stepLongDesc: '' }
}

function openEdit(step) {
  showForm.value = true
  editing.value = step

  form.value = {
    itemCodeID: step.itemCodeID,
    stepTitle: step.stepTitle,
    stepLongDesc: step.stepLongDesc
  }
}

function cancel() {
  showForm.value = false
  editing.value = null
  form.value = { itemCodeID: '', stepTitle: '', stepLongDesc: '' }
}

async function save() {
  try {
    if (editing.value) {
      await updateStep(editing.value.prepStepID, form.value)
      window.alert("Step updated!")
    } else {
      await createStep(form.value)
      window.alert("Step created!")
    }

    cancel()
    await load()

  } catch (err) {
    window.alert(err?.response?.data?.message || "Error saving step")
  }
}

async function remove(id) {
  if (!window.confirm("Delete this step?")) return

  try {
    await deleteStep(id)
    await load()
  } catch (err) {
    window.alert(err?.response?.data?.message || "Error deleting step")
  }
}

onMounted(load)
</script>

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



.steps-section {
  background: #fff;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  margin: 1rem auto;
  max-width: 900px;
}

.steps-header {
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


.btn.add, .btn.refresh, .btn.update, .btn.delete, .btn.create, .btn.cancel {
  background-color: pink;
  color: #000;
  font-weight: 600;
}
.btn.add:hover, .btn.refresh:hover, .btn.update:hover, .btn.delete:hover, .btn.create:hover, .btn.cancel:hover {
  background-color: #ffb6c1;
}

.btn.back { background: #0275d8; }

.steps-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.95rem;
}

.steps-table th,
.steps-table td {
  border: 1px solid var(--border);
  padding: 0.75rem 1rem;
}

.steps-table th {
  background-color: #e7f3e5;
  font-weight: 700;
}

.step-form {
  background: #f9f9f9;
  padding: 1rem;
  border: 1px solid var(--border);
  border-radius: 8px;
  margin-bottom: 1rem;
}

.form-row {
  margin-bottom: 0.75rem;
  display: flex;
  align-items: center;
  gap: 10px;
}
.form-row label {
  width: 100px;
  text-align: right;
  font-weight: 600;
}
.form-row input {
  flex-grow: 1;
  padding: 8px;
  border: 1px solid var(--border);
  border-radius: 4px;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 15px;
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