<template>
<section class="container">
<h2 class="title">Dispose Right with TUSBINRight++</h2>
<h2>Find the right bin for your taste</h2>

<!-- Search & Scanner Section -->
<div class="search-placeholder">
  <input
      v-model="searchInput"
      placeholder="Enter product name or barcode..."
  />
  <button @click="toggleScanner" class="scan-btn">
    📷 Scan
  </button>
</div>

<!-- Scanner appears when toggled -->
<div v-if="showScanner" class="scanner-area">
  <BarcodeScanner @scanned="handleScanned" />
  <button @click="toggleScanner" class="close-btn">Close Scanner</button>
</div>

<div class="how-it-works">
  <p class="How">How it works:</p>
</div>

<!-- How it works -->
<div class="how-it-works-steps">
  <div>
    <p class="bigger-text">1. Enter it or scan</p>
    <img src="../images/glass.png" height="85" width="150" />
  </div>
  <div>
    <p class="bigger-text">2. Get disposal result and instructions</p>
    <img src="../images/result.png" height="85" width="135" />
  </div>
  <div>
    <p class="bigger-text">3. Recycle the right way</p>
    <img src="../images/bin.png" height="85" width="120" />
  </div>
</div>
</section>

</template>

<script setup>
import { ref } from "vue";
import BarcodeScanner from "@/components/BarcodeScanner.vue";

const searchInput = ref("");
const showScanner = ref(false);

const toggleScanner = () => {
  showScanner.value = !showScanner.value;
};

const handleScanned = (code) => {
  searchInput.value = code; // fill input with scanned code
  showScanner.value = false;
  alert(`Scanned: ${code}`); // temporary feedback
};
</script>

<style scoped>

.container {
  text-align: center;
  padding: 40px 20px;
  max-width: 1000px;
  margin: 0 auto;
}

.title {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 10px;
}

.search-placeholder {
  width: 60%;
  margin: 0 auto 20px auto;
  padding: 18px;
  border: 2px dashed #aaa;
  border-radius: 8px;
  display: flex;
  gap: 10px;
  align-items: center;
  justify-content: center;
}

.scan-btn,
.close-btn {
  padding: 8px 14px;
  border: none;
  border-radius: 6px;
  background-color: #2c7a7b;
  color: white;
  cursor: pointer;
  font-size: 16px;
}

.close-btn {
  background-color: #e74c3c;
  margin-top: 10px;
}

.scanner-area {
  margin: 20px auto;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.How {
  font-size: 27px;
  font-weight: bold;
  margin-top: 40px;
}

.how-it-works-steps {
  display: flex;
  justify-content: space-around;
  gap: 20px;
  margin-top: 30px;
  flex-wrap: wrap;
}

.bigger-text {
  font-size: 20px;
  font-weight: bold;
}
</style>
