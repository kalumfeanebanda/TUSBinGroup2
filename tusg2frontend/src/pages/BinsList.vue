<script setup>
import { ref, onMounted } from 'vue'
import { listBins, deleteBin, createBin, updateBin } from '@/services/bins'




const bins = ref([])
const loading = ref(true)
const error = ref('')


const showForm = ref(false)      // controls if form is visible
const editing = ref(null)        // holds bin being edited
const form = ref({ binName: '', binDesc: '' })


async function load(){
  loading.value = true; error.value = ''
  try { bins.value = await listBins() }
  catch { error.value = 'Could not load bins.' }
  finally { loading.value = false }
}


async function onDelete(id) {
  const yes = confirm('Delete this bin?');
  if (!yes) return;

  try {
    await deleteBin(id);
    await load();
  } catch (err) {
    alert(err?.response?.data?.message ?? 'Delete failed');
  }
}

// SHOW CREATE
function openCreate() {
  showForm.value = true
  editing.value = null
  form.value = { binName: '', binDesc: '' }
}

// SHOW UPDATE
function openEdit(bin) {
  showForm.value = true
  editing.value = bin
  form.value = { binName: bin.binName, binDesc: bin.binDesc }
}

// CANCEL FORM
function cancelForm() {
  showForm.value = false
  editing.value = null
  form.value = { binName: '', binDesc: '' }
}

// SAVE (create or update)
async function saveBin() {
  try {
    if (!form.value.binName) return alert('Bin name is required.')
    if (editing.value) {
      const row = await updateBin(editing.value.binTypeID, form.value)
      const i = bins.value.findIndex(b => b.binTypeID === editing.value.binTypeID)
      if (i !== -1) bins.value[i] = row
      alert('Bin updated!')
    } else {
      const row = await createBin(form.value)
      bins.value.unshift(row)
      alert('Bin created!')
    }
    cancelForm()
  } catch (err) {
    alert(err?.response?.data?.message ?? 'Save failed')
  }
}

onMounted(load)
</script>

<template>
  <section class="bins-section">
    <div class="bins-header">
      <h2>Manage Bins</h2>
      <div class="controls">
        <button class="btn add" @click="openCreate">+ Add Bin</button>
        <button class="btn refresh" @click="load">Refresh</button>
      </div>
    </div>


    <!-- Create / Update Form -->
    <div v-if="showForm" class="bin-form">
      <h3>{{ editing ? 'Update Bin' : 'Create New Bin' }}</h3>
      <div class="form-row">
        <label>Bin Name:</label>
        <input v-model="form.binName" placeholder="Enter name" />
      </div>
      <div class="form-row">
        <label>Description:</label>
        <input v-model="form.binDesc" placeholder="Enter description" />
      </div>
      <div class="form-actions">
        <button class="btn save" @click="saveBin">{{ editing ? 'Save Changes' : 'Create Bin' }}</button>
        <button class="btn cancel" @click="cancelForm">Cancel</button>
      </div>
    </div>




    <div v-if="loading" class="state">Loading…</div>
    <div v-else-if="error" class="state error">{{ error }}</div>
    <div v-else-if="bins.length === 0" class="state">No bins found.</div>

    <table v-else class="bins-table">
      <thead>
      <tr>
        <th style="width: 80px">#</th>
        <th>Bin Name</th>
        <th>Description</th>
        <th style="width: 220px">Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="b in bins" :key="b.binTypeID">
        <td class="muted">{{ b.binTypeID }}</td>
        <td>{{ b.binName }}</td>
        <td>{{ b.binDesc }}</td>
        <td class="actions">
          <button class="btn view">View</button>
          <button class="btn update" @click="openEdit(b)">Update</button>
          <button class="btn delete" @click="onDelete(b.binTypeID)">Delete</button>
        </td>
      </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>
:root {
  --green: #4b8b3b;
  --green-d: #3d7a31;
  --red: #d9534f;
  --blue: #0275d8;
  --muted: #6b7280;
  --border: #e0e0e0;
}

/* Layout */
.bins-section {
  background: #fff;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  margin: 2rem auto;
  max-width: 900px;
}

/* Header */
.bins-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid var(--green);
  padding-bottom: 0.75rem;
  margin-bottom: 1rem;
}

.bins-header h2 {
  margin: 0;
  color: #2f4f27;
  font-size: 1.4rem;
}

.controls {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.search-box {
  padding: 0.45rem 0.75rem;
  border: 1px solid var(--border);
  border-radius: 8px;
  min-width: 200px;
}

.btn {
  color: #fff;
  padding: 0.4rem 0.85rem;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.85rem;
  cursor: pointer;
  transition: none; /* disables hover transitions */
}

.btn.refresh { background-color: purple; }
.btn.add {
  background-color: pink ;
   }
.btn.view { background-color: var(--blue); }
.btn.update { background-color: var(--green); }
.btn.delete { background-color: var(--red); }


.bin-form {
  background: #f9f9f9;
  padding: 1rem;
  border: 1px solid var(--border);
  border-radius: 8px;
  margin-bottom: 1rem;
}

.form-row {
  margin-bottom: 0.75rem;
  display: flex;
  flex-direction: column;
}

.form-actions {
  display: flex;
  gap: 0.5rem;
}






/* Each button color */
.btn.view {
  background-color: #0275d8; /* blue */
}

.btn.update {
  background-color: #4b8b3b; /* green */
}

.btn.delete {
  background-color: #d9534f; /* red */
}

/* Table */
.bins-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.95rem;
}

.bins-table th,
.bins-table td {
  border: 1px solid var(--border);
  padding: 0.75rem 1rem;
  text-align: left;
}

.bins-table th {
  background-color: #e7f3e5;
  font-weight: 700;
  color: #2f4f27;
}

.bins-table tr:nth-child(even) {
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

.bin-form .btn.save {
  background-color: #3a7f2a; /* softer green */
}

.bin-form .btn.cancel {
  background-color: #aaa; /* neutral gray */
}
.bin-form .btn.cancel:hover {
  background-color: #888;
}


</style>