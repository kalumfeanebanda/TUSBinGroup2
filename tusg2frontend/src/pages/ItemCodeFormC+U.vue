<template>
  <form class="bin-form" @submit.prevent="onSubmit">
    <h3>{{ isEdit ? 'Edit Barcode' : 'Create Barcode' }}</h3>

    <div class="row">
      <label>Item</label>
      <select v-model.number="local.itemID" required>
        <option :value="0" disabled>Select an item…</option>
        <option
            v-for="item in items"
            :key="item.itemID"
            :value="item.itemID"
            :disabled="isItemTaken(item.itemID)"
        >
          {{ item.itemName }} <span v-if="isItemTaken(item.itemID)"> (has barcode)</span>
        </option>
      </select>
    </div>

    <div class="row">
      <label>Barcode Value</label>
      <input v-model.trim="local.codeValue" required maxlength="128" placeholder="Enter barcode" />
    </div>

    <div class="actions">
      <button type="submit" :disabled="saving">
        {{ saving ? (isEdit ? 'Saving…' : 'Creating…') : (isEdit ? 'Save' : 'Create') }}
      </button>

      <button type="button" class="ghost" @click="onCancel" :disabled="saving">
        Cancel
      </button>


      <span v-if="error" class="error">{{ error }}</span>
    </div>
  </form>
</template>

<script setup>
import { computed, reactive, watch, ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { createItemCode, updateItemCode, listItemCodes } from '@/services/itemCodes'
import { listItems } from '@/services/items'

const route = useRoute()
const router = useRouter()


const editId = computed(() => {
  const id = route.params.id
  return id ? Number(id) : null
})

const isEdit = computed(() => !!editId.value)

const items = ref([])
const takenItemIds = ref([])

const local = reactive({
  itemID: 0,
  codeValue: ''
})

const saving = ref(false)
const error = ref('')

function isItemTaken(itemID) {
  if (isEdit.value && itemID === local.itemID) return false
  return takenItemIds.value.includes(itemID)
}

async function onSubmit() {
  error.value = ''
  saving.value = true

  try {
    const payload = {
      itemID: local.itemID,
      codeValue: local.codeValue
    }

    if (isEdit.value && editId.value) {
      await updateItemCode(editId.value, payload)
      alert('Barcode updated!')
    } else {
      await createItemCode(payload)
      alert('Barcode created!')
    }

    router.push('/itemcodes')
  } catch (e) {
    console.error(e)
    error.value = e?.response?.data?.message || 'Request failed'
  } finally {
    saving.value = false
  }
}

function onCancel() {
  if (saving.value) return
  router.push('/itemcodes')
}

onMounted(async () => {
  items.value = await listItems()
  const codes = await listItemCodes()
  takenItemIds.value = codes.map(c => c.itemID)

  if (isEdit.value && editId.value) {
    const current = codes.find(c => Number(c.codeID) === editId.value)
    if (!current) {
      alert('Barcode not found.')
      router.push('/itemcodes')
      return
    }
    local.itemID = current.itemID
    local.codeValue = current.codeValue
  }

})
</script>


<style scoped>

.bin-form {
  background:#fff;
  border:1px solid #e5e7eb;
  border-radius:12px;
  padding:1rem;
  display:grid;
  gap:.75rem;
}
.row { display:grid; gap:.35rem; }
.row input, .row select {
  border:1px solid #d1d5db;
  padding:.5rem .6rem;
  border-radius:8px;
}
.actions { display:flex; gap:.5rem; align-items:center; }
button { border:none; padding:.55rem .9rem; border-radius:10px; background:#2563eb; color:#fff; cursor:pointer; }
button.ghost { background:transparent; border:1px solid #d1d5db; color:#111827; }
button[disabled]{opacity:.7; cursor:not-allowed;}
.error { color:#b91c1c; margin-left:auto; }
</style>
