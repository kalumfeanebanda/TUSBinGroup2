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
              v-model="textSearch"
              placeholder="Search item"
              class="item-search-input"
              @input="onTextInput"
              @keypress.enter.prevent="performTextSearch"
          />
        </div>
        <div v-if="matches.length" class="match-results-box">
          <ul>
            <li
                v-for="item in matches"
                :key="item.itemID"
                class="match-item"
                @click="goToResult(item.itemID)"
            >
              {{ item.itemName }}
            </li>
          </ul>
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
              v-model="barcodeSearch"
              placeholder="Enter BarCode Number"
              class="barcode-input"
              @keypress.enter="submitBarcode"
          />
        </div>
        <button @click="submitBarcode" class="search-btn primary-btn">
          Submit Barcode
        </button>
        <p class="or-separator">- OR -</p>

        <button @click="toggleScanner" class="scan-your-barcode-btn primary-btn">
          📷 Scan Your BarCode
        </button>
      </div>

    </div>
    <div>
      <p class="subtitle"></p>
    </div>
    <div v-if="showScanner" class="scanner-area">
      <BarcodeScanner @scanned="handleScanned" />
      <button @click="toggleScanner" class="close-btn">Close Scanner</button>
    </div>
  </section>
    <FeedbackModal
        :show="showFeedback"
        @close="showFeedback = false"
    />
  </section>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import BarcodeScanner from "@/components/BarcodeScanner.vue";
import FeedbackModal from "@/components/FeedbackModal.vue";
import { searchNames, searchByBarcode } from '@/services/items'


const router = useRouter();
  
  const showFeedback = ref(false);
  
  
  const textSearch = ref("");      // for typing item names
const barcodeSearch = ref("");   // for manual barcode entry
const showScanner = ref(false);
const matches = ref([]);




const toggleScanner = () => {
  showScanner.value = !showScanner.value;
};

const onTextInput = async () => {
  const q = textSearch.value.trim();

  if (q.length < 2) {
    matches.value = [];
    return;
  }

  try {
    const results = await searchNames(q);
    matches.value = results;
  } catch (err) {
    console.error(err);
  }
};



const performTextSearch = async () => {
  const q = textSearch.value.trim();
  if (!q) {
    alert("Please enter an item name to search!");
    return;
  }


  try {
    const results = await searchNames(q);

    if (results.length === 0) {
      handleNameNotFound(q);
      matches.value = []; // make sure list clears when nothing found
      return;
    }

    const exact = results.find(
        item => item.itemName.toLowerCase() === q.toLowerCase()
    );

    if (exact) {
      goToResult(exact.itemID);
      return;
    }


    handleNameNotFound(q);
    matches.value = [];

  } catch (err) {
    console.error(err);
    alert("Search failed. Try again.");
  }
};



const goToResult = (id) => {
  router.push({
    name: "item-result",
    query: { id }
  });
};



const handleNameNotFound = (q) => {
  showFeedback.value = true;                 // open FeedbackModal
  alert(`No item found for "${q}".`);        // current simple behaviour
};






const submitBarcode = async () => {
  const code = barcodeSearch.value.trim();
  if (!code) {
    alert("Please enter or scan a barcode first!");
    return;
  }

  try {
    const data = await searchByBarcode(code);


    goToResult(data.itemID);

  } catch (err) {
    console.error(err);

    if (err?.response?.status === 404) {

      handleNameNotFound(code);
    } else {
      alert("Barcode search failed. Please try again.");
    }
  } finally {
    barcodeSearch.value = "";
  }
};


const handleScanned = (code) => {
  barcodeSearch.value = code;   
  showScanner.value = false;
  submitBarcode();              
};
</script>

<style scoped>

/* search name styles */

.match-results-box {
  margin-top: 10px;
  background: #ffffff;
  border: 1px solid #ccc;
  border-radius: 8px;
  max-width: 350px;
  width: 100%;
  text-align: left;
}

.match-results-box ul {
  list-style: none;
  margin: 0;
  padding: 4px 0;
}

.match-item {
  padding: 8px 12px;
  cursor: pointer;
}

.match-item + .match-item {
  border-top: 1px solid #eee;
}

.match-item:hover {
  background-color: #f0f0f0;
}
/* end search names */






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