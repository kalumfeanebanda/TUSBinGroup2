<template>
  <section class="image">
    <section class="result-page-container">
      <h1 class="main-title">Item Result</h1>
      <p class="subtitle">Here’s how to bin and prepare this item.</p>

      <div v-if="loading" class="status muted">Loading item…</div>
      <div v-else-if="error" class="status error">{{ error }}</div>

      <div v-else class="result-card">
        <p class="found-via">Found via: NAME</p>

        <!-- Item details -->
        <div class="info-block">
          <h3 class="section-title">Item Details</h3>
          <div class="kv">
            <div><span>Item:</span> {{ item.itemName }}</div>
            <div><span>Description:</span> {{ item.itemDesc || '—' }}</div>
          </div>
        </div>

        <!-- Bin details -->
        <div class="info-block">
          <h3 class="section-title">Recommended Bin</h3>
          <div v-if="item.recommendedBin" class="kv">
            <div><span>Bin Name:</span> {{ item.recommendedBin.binName }}</div>
            <div><span>Bin Info:</span> {{ item.recommendedBin.binDesc }}</div>
          </div>
          <p v-else class="muted">No bin recommendation found for this item.</p>
        </div>

        <!-- Rule note -->
        <div class="info-block">
          <h3 class="section-title">Rule for this item</h3>
          <p>{{ item.ruleNote || 'No specific rule for this item.' }}</p>
        </div>

        <!-- Prep steps -->
        <div class="info-block">
          <h3 class="section-title">How to prepare for this bin</h3>
          <ol v-if="item.prepSteps && item.prepSteps.length">
            <li v-for="step in item.prepSteps" :key="step.stepOrder">
              {{ step.stepDesc }}
            </li>
          </ol>
          <p v-else class="muted">No preparation steps defined for this bin.</p>
        </div>

        <div class="actions-row">
          <router-link :to="{ name: 'search-items' }" class="btn secondary-btn">
            ← Back to Search
          </router-link>
        </div>
      </div>
    </section>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { getItem } from '@/services/items'

const route = useRoute()

const item = ref(null)
const loading = ref(true)
const error = ref('')

const loadItem = async () => {
  const id = route.query.id

  if (!id) {
    error.value = 'Missing item id.'
    loading.value = false
    return
  }

  try {
    const data = await getItem(id)
    item.value = data
  } catch (e) {
    console.error(e)
    error.value =
        e?.response?.data?.message || 'Could not load item details.'
  } finally {
    loading.value = false
  }
}

onMounted(loadItem)
</script>

<style scoped>
.result-page-container {
  text-align: center;
  padding: 40px 20px;
  max-width: 900px;
  margin: 0 auto;
}

.main-title {
  font-size: 2.3rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 5px;
}

.subtitle {
  font-size: 1.1rem;
  color: #555;
  margin-bottom: 25px;
}

.status {
  margin-top: 20px;
}

.muted {
  color: #777;
  font-size: 0.95rem;
}

.error {
  color: #b00020;
}

/* Card that matches your other sections */
.result-card {
  margin-top: 10px;
  padding: 30px;
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  background-color: #f9f9f9;
  text-align: left;
}

/* “Found via” line */
.found-via {
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 0.9rem;
  color: #555;
  margin-bottom: 16px;
}

/* Block sections */
.info-block {
  margin-bottom: 22px;
}

.section-title {
  font-size: 1.1rem;
  font-weight: bold;
  color: #1d8348;
  margin-bottom: 10px;
}

/* Key–value layout like a neat info table */
.kv {
  display: grid;
  grid-template-columns: 130px 1fr;
  gap: 6px 16px;
  font-size: 0.98rem;
}

.kv span {
  font-weight: 600;
  color: #333;
}

/* Buttons row */
.actions-row {
  margin-top: 10px;
  display: flex;
  justify-content: flex-end;
}

/* Button styles mimicking your primary / unified buttons */
.btn {
  display: inline-block;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 0.98rem;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  transition: background-color 0.25s ease, color 0.25s ease, border-color 0.25s ease;
}

/* Secondary / back button style but still on-brand */
.secondary-btn {
  background-color: #ffffff;
  color: #1d8348;
  border: 2px solid #1d8348;
}

.secondary-btn:hover {
  background-color: #1d8348;
  color: #ffffff;
}
</style>
