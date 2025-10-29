<template>
  <form class="bin-form" @submit.prevent="onSubmit">
    <h3>{{ isEdit ? 'Edit Bin' : 'Create Bin' }}</h3>

    <div class="row">
      <label>Bin Name</label>
      <input v-model.trim="local.binName" required maxlength="20" placeholder="e.g., Recycling" />
    </div>

    <div class="row">
      <label>Description (optional)</label>
      <input v-model.trim="local.binDesc" maxlength="75" placeholder="Short description" />
    </div>

    <div class="actions">

      <button type="submit" :disabled="saving">
        {{ saving ? (isEdit ? 'Saving…' : 'Creating…') : (isEdit ? 'Save' : 'Create') }}
      </button>

      <button
          type="button"
          class="ghost"
          @click.stop="$emit('cancel')"
          :disabled="saving"
      >
        Cancel
      </button>
      <span v-if="error" class="error">{{ error }}</span>
    </div>
  </form>
</template>

<script setup>
import { computed, reactive, watch, ref } from 'vue'
import { createBin, updateBin } from '@/services/bins'

// Props: pass an existing bin for edit, or nothing for create
const props = defineProps({
  bin: {
    type: Object,
    default: null, // { binTypeID, binName, binDesc }
  },
})

const emit = defineEmits(['saved', 'cancel'])

const isEdit = computed(() => !!props.bin?.binTypeID)
const local = reactive({
  binName: props.bin?.binName ?? '',
  binDesc: props.bin?.binDesc ?? '',
})
watch(() => props.bin, (b) => {
  local.binName = b?.binName ?? ''
  local.binDesc = b?.binDesc ?? ''
})

const saving = ref(false)
const error = ref('')

async function onSubmit() {
  error.value = ''
  saving.value = true
  try {
    const payload = { binName: local.binName, binDesc: local.binDesc || null }

    const res = isEdit.value
        ? await updateBin(props.bin.binTypeID, payload)
        : await createBin(payload)

    emit('saved', res)
  } catch (e) {
    console.log('CREATE/UPDATE error:', e?.response?.status, e?.response?.data)
    error.value = e.friendlyMessage || e?.response?.data?.message || e?.message || 'Request failed.'
  } finally {
    saving.value = false
  }
}
</script>

<style scoped>
.bin-form { background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:1rem; display:grid; gap:.75rem; }
.row { display:grid; gap:.35rem; }
.row input { border:1px solid #d1d5db; padding:.5rem .6rem; border-radius:8px; }
.actions { display:flex; gap:.5rem; align-items:center; }
button { border:none; padding:.55rem .9rem; border-radius:10px; background:#2563eb; color:#fff; cursor:pointer; }
button.ghost { background:transparent; border:1px solid #d1d5db; color:#111827; }
button[disabled]{opacity:.7; cursor:not-allowed;}
.error { color:#b91c1c; margin-left:auto; }
</style>