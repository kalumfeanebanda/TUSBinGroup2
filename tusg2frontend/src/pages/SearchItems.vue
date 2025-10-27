<template>
  <section class="image">
  <section class="search-items-page-container">
    <h1 class="main-title">Search Items</h1>
    <p class="subtitle">What way you want to choose?</p>

    <div class="search-options-wrapper">

      <div class="search-section text-search-section">
        <h3 class="section-title">Search Items by search bar</h3>

        <div class="search-input-group">
          <i class="fas fa-search search-icon-prefix"></i>

          <input
              type="text"
              v-model="searchInput"
              placeholder="Search item "
              class="item-search-input"
              @keypress.enter="performTextSearch"
          />
        </div>

        <button @click="performTextSearch" class="search-btn primary-btn">
          Search
        </button>
      </div>

      <div class="search-section barcode-search-section">
        <h3 class="section-title">Type or Scan BarCode</h3>

        <div class="barcode-input-group">
          <i class="fas fa-barcode barcode-icon-prefix"></i>
          <input
              type="text"
              v-model="searchInput"
              placeholder="Enter BarCode Number"
              class="barcode-input"
              @keypress.enter="submitBarcode"
          />
        </div>

        <p class="or-separator">- OR -</p>

        <button @click="toggleScanner" class="scan-your-barcode-btn primary-btn">
          📷 Scan Your BarCode
        </button>
      </div>

    </div>

    <div v-if="showScanner" class="scanner-area">
      <BarcodeScanner @scanned="handleScanned" />
      <button @click="toggleScanner" class="close-btn">Close Scanner</button>
    </div>
  </section>
  </section>
</template>

<script setup>
import { ref } from "vue";
import BarcodeScanner from "@/components/BarcodeScanner.vue";

// Reusing searchInput for both text and barcode number entry for simplicity
const searchInput = ref("");
const showScanner = ref(false);

const toggleScanner = () => {
  showScanner.value = !showScanner.value;
};

// 🔹 Handles scanned barcode from the scanner
const handleScanned = (code) => {
  searchInput.value = code; // fill input with scanned code
  showScanner.value = false;
  alert(`Scanned barcode: ${code}`);
  submitBarcode(); // Auto-submit after scan
};

// 🔹 Handles product name submission (Text Search)
const performTextSearch = () => {
  if (!searchInput.value.trim()) {
    alert("Please enter an item name to search!");
    return;
  }
  alert(`Searching for product name: ${searchInput.value.trim()}`);
  searchInput.value = "";
};

// 🔹 Handles manual barcode number submission
const submitBarcode = () => {
  if (!searchInput.value.trim()) {
    alert("Please enter or scan a barcode first!");
    return;
  }
  // In a real app, you would check if the input is a valid barcode number
  alert(`Submitted Barcode: ${searchInput.value}`);
  searchInput.value = "";
};
</script>

<style scoped>
/* ==================================== */
/* BASE LAYOUT & TEXT */
/* ==================================== */
/* .image{
  background:url("../images/BG.jpg");}*/


.search-items-page-container {

  text-align: center;
  padding: 40px 20px;
  max-width: 1000px; /* Wider container for the two columns */
  margin: 0 auto;
}

.main-title {
  font-size: 2.5rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 5px;
}

.subtitle {
  font-size: 1.2rem;
  color: #555;
  margin-bottom: 40px;
}

.search-options-wrapper {
  display: flex;
  justify-content: space-around;
  gap: 40px;
  flex-wrap: wrap;
}

/* Base style for the two main columns */
.search-section {
  flex: 1;
  min-width: 300px;
  padding: 30px;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  background-color: #f9f9f9;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 25px;
}

.section-title {
  font-size: 1.3rem;
  font-weight: bold;
  color: #1d8348; /* Dark green from your original buttons */
  margin-bottom: 10px;
}

/* ==================================== */
/* INPUT STYLES (Shared) */
/* ==================================== */
.search-input-group,
.barcode-input-group {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 350px;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 5px;
  background-color: #fff;
}

.item-search-input,
.barcode-input {
  flex-grow: 1;
  border: none;
  outline: none;
  padding: 10px 10px; /* Added internal padding */
  font-size: 1rem;
  color: #333;
}

.search-icon-prefix,
.barcode-icon-prefix {
  padding: 0 10px;
  color: #888;
  font-size: 1.2rem;
}

/* ==================================== */
/* BUTTON STYLES (Unified) */
/* ==================================== */
.primary-btn {
  background-color: #1d8348; /* Submit color */
  color: white;
  padding: 15px 30px;
  border: none;
  border-radius: 8px;
  font-size: 1.1rem;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: 80%;
  max-width: 250px;
}

.primary-btn:hover {
  background-color: #145a17; /* Darker green on hover */
}

.or-separator {
  font-weight: bold;
  color: #666;
}


/* ==================================== */
/* SCANNER AREA (Reused) */
/* ==================================== */
.scanner-area {
  margin-top: 40px;
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 1px solid #eee;
  padding: 20px;
  border-radius: 8px;
  background-color: #fff;
}

.close-btn {
  background-color: #e74c3c;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  margin-top: 15px;
  cursor: pointer;
}

.close-btn:hover {
  background-color: #d63e2e;
}

@media (max-width: 768px) {
  .search-options-wrapper {
    flex-direction: column;
    gap: 20px;
  }
  .primary-btn {
    width: 100%;
    max-width: none;
  }
}
</style>