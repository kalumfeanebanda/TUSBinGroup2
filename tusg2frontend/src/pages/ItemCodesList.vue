<script setup>
import { ref, onMounted } from 'vue'
import { listItemCodes, deleteItemCode } from '@/services/itemCodes'
import { useRouter } from 'vue-router'

const router = useRouter()

const codes = ref([])
const loading = ref(true)
const error = ref('')

async function load() {
  loading.value = true
  error.value = ''
  try {
    codes.value = await listItemCodes()
  } catch (err) {
    error.value = 'Could not load barcodes.'
  } finally {
    loading.value = false
  }
}

async function onDelete(id) {
  const yes = confirm('Delete this barcode?')
  if (!yes) return

  try {
    await deleteItemCode(id)
    await load()
  } catch (err) {
    alert(err?.response?.data?.message ?? 'Delete failed')
  }
}

function openCreate() {
  router.push('/itemcodes/new')
}

function openEdit(id) {
  router.push(`/itemcodes/${id}/edit`)
}

onMounted(load)
</script>

<template>
  <section class="bins-section">
    <div class="bins-header">
      <h2>Manage Barcodes</h2>
      <div class="controls">
        <button class="btn add" @click="openCreate">+ Add Barcode</button>
        <button class="btn refresh" @click="load">Refresh</button>
      </div>
    </div>

    <div v-if="loading" class="state">Loading…</div>
    <div v-else-if="error" class="state error">{{ error }}</div>
    <div v-else-if="codes.length === 0" class="state">No barcodes found.</div>

    <table v-else class="bins-table">
      <thead>
      <tr>
        <th style="width: 80px">#</th>
        <th>Item</th>
        <th>Item ID</th>
        <th>Barcode</th>
        <th style="width: 220px">Actions</th>
      </tr>
      </thead>

      <tbody>
      <tr v-for="c in codes" :key="c.codeID">
        <td class="muted">{{ c.codeID }}</td>
        <td>{{ c.itemName }}</td>
        <td>{{ c.itemID }}</td>
        <td>{{ c.codeValue }}</td>
        <td class="actions">
          <button class="btn view">View</button>
          <button class="btn update" @click="openEdit(c.codeID)">Update</button>
          <button class="btn delete" @click="onDelete(c.codeID)">Delete</button>
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

.bins-section {
  background: #fff;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  margin: 2rem auto;
  max-width: 900px;
}


.bins-header {
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
  font-size: 0.85rem;
  cursor: pointer;
  transition: none;
}

.btn.add { background-color: pink; }
.btn.refresh { background-color: purple; }
.btn.update { background-color: var(--green); }
.btn.delete { background-color: var(--red); }

.btn.view {
  background-color: #0275d8; /* blue */
}

.btn.update {
  background-color: #4b8b3b; /* green */
}

.btn.delete {
  background-color: #d9534f; /* red */
}

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

.actions {
  display: flex;
  gap: 0.5rem;
}

.state {
  padding: 1rem;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 10px;
  text-align: center;
}

.state.error {
  color: #b91c1c;
}
</style>
