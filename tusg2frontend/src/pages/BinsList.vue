<script setup>
import { ref, onMounted } from 'vue'
import { listBins } from '@/services/bins'

const bins = ref([])
const loading = ref(true)
const error = ref('')

async function load(){
  loading.value = true; error.value = ''
  try { bins.value = await listBins() }
  catch { error.value = 'Could not load bins.' }
  finally { loading.value = false }
}
onMounted(load)
</script>

<template>
  <section class="bins-section">
    <div class="bins-header">
      <h2>Manage Bins</h2>
      <button class="btn refresh" @click="load">Refresh</button>
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
          <button class="btn update">Update</button>
          <button class="btn delete">Delete</button>
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
</style>