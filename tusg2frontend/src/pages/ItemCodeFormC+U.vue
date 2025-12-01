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

      <button type="button" class="ghost" @click="$emit('cancel')" :disabled="saving">
        Cancel
      </button>

      <span v-if="error" class="error">{{ error }}</span>
    </div>
  </form>
</template>

<script setup>
import { computed, reactive, watch, ref, onMounted } from 'vue'
import { createItemCode, updateItemCode, listItemCodes } from '@/services/itemCodes'
import { listItems } from '@/services/items'

const props = defineProps({
  code: { type: Object, default: null }
})

const emit = defineEmits(['saved', 'cancel'])

const items = ref([])

const takenItemIds = ref([])

const isEdit = computed(() => !!props.code?.codeID)

const local = reactive({
  itemID: props.code?.itemID ?? 0,
  codeValue: props.code?.codeValue ?? ''
})

watch(() => props.code, (c) => {
  local.itemID = c?.itemID ?? 0
  local.codeValue = c?.codeValue ?? ''
})

const saving = ref(false)
const error = ref('')


function isItemTaken(itemID) {

  if (isEdit.value && itemID === props.code?.itemID) return false
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

    const res = isEdit.value
        ? await updateItemCode(props.code.codeID, payload)
        : await createItemCode(payload)

    emit('saved', res)
  } catch (e) {
    error.value = e?.response?.data?.message || 'Request failed'
  } finally {
    saving.value = false
  }
}

onMounted(async () => {

  items.value = await listItems()
  const codes = await listItemCodes()
  takenItemIds.value = codes.map(c => c.itemID)
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
