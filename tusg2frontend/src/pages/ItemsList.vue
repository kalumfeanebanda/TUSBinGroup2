<script setup>
import { ref, onMounted } from 'vue'
import { listItems, deleteItem, createItem, updateItem } from '@/services/items'

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
      alert("Item added!")
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
  <section class="items-section">
    <div class="items-header">
      <h2>Manage Items</h2>
      <div class="controls">
        <button class="btn add" @click="openCreate">+ Add Item</button>
        <button class="btn refresh" @click="load">Refresh</button>
      </div>
    </div>

    <!-- Create / Edit Form -->
    <div v-if="showForm" class="item-form">
      <h3>{{ editing ? 'Edit Item' : 'Create New Item' }}</h3>

      <div class="form-row">
        <label>Item Name:</label>
        <input v-model="form.itemName" placeholder="Enter item name" />
      </div>

      <div class="form-row">
        <label>Description:</label>
        <input v-model="form.itemDesc" placeholder="Enter description" />
      </div>

      <div class="form-actions">
        <button class="btn update" @click="save">Save</button>
        <button class="btn cancel" @click="cancel">Cancel</button>
      </div>
    </div>

    <div v-if="loading" class="state">Loading…</div>
    <div v-else-if="error" class="state error">{{ error }}</div>
    <div v-else-if="items.length === 0" class="state">No items found.</div>

    <table v-else class="items-table">
      <thead>
      <tr>
        <th style="width: 80px">#</th>
        <th>Item Name</th>
        <th>Description</th>
        <th style="width: 220px">Actions</th>
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
.items-section {
  background: #fff;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  margin: 2rem auto;
  max-width: 900px;
}

/* Header */
.items-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid var(--green);
  padding-bottom: 0.75rem;
  margin-bottom: 1rem;
}

.items-header h2 {
  margin: 0;
  color: #2f4f27;
  font-size: 1.4rem;
}

.controls {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

/* Buttons */
.btn {
  color: #fff;
  padding: 0.4rem 0.85rem;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.85rem;
  cursor: pointer;
}

.btn.refresh { background-color: purple; }
.btn.add { background-color: pink; }
.btn.update { background-color: var(--green); }
.btn.delete { background-color: var(--red); }

/* Table */
.items-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.95rem;
}

.items-table th,
.items-table td {
  border: 1px solid var(--border);
  padding: 0.75rem 1rem;
  text-align: left;
}

.items-table th {
  background-color: #e7f3e5;
  font-weight: 700;
  color: #2f4f27;
}

.items-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.actions {
  display: flex;
  gap: 0.5rem;
}

.muted {
  color: var(--muted);
}

/* Form */
.item-form {
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

.form-row input {
  padding: 0.7rem;
  border: 1px solid var(--border);
  border-radius: 6px;
}

.form-actions {
  display: flex;
  gap: 0.5rem;
}

.btn.cancel {
  background-color: #aaa;
}

.btn.cancel:hover {
  background-color: #888;
}

/* State messages */
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
