<template>
  <div class="home-page">

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>Dispose Right with TUSBinRight++</h1>
        <p>Find the right bin for your taste</p>
        <div class="hero-buttons">
          <button class="btn how-btn">How it works</button>
          <button class="btn scan-btn" @click="goToSearchItems">Scan Now</button>
        </div>
      </div>
    </section>

    <!-- What is this -->
    <section class="info-section">
      <h2>What is this?</h2>
      <div class="info-columns">
        <div class="info-box">
          <p>
            <strong>TUSBinRight++</strong> is a detailed recycling search database with website
            and mobile app including barcode scanning and search items.
          </p>
        </div>
        <div class="info-box">
          <p>
            <strong>TUSBinRight++</strong> helps your residents work out what to recycle where.
            Our simple to use recycling search tool on your website or via our mobile apps incl.
            barcode scanning. We can save you time and money dealing with questions.
          </p>
        </div>
      </div>
    </section>

    <!-- How it works -->
    <section class="how-section">
      <h2>How it works:</h2>
      <div class="steps">
        <div>
          <img src="../images/glass.png" height="60" />
          <p>1. Enter it or scan</p>
        </div>
        <div>
          <img src="../images/result.png" height="60" />
          <p>2. Get disposal result and instructions</p>
        </div>
        <div>
          <img src="../images/bin.png" height="60" />
          <p>3. Recycle the right way</p>
        </div>
      </div>
    </section>

    <!-- What it does -->
    <section class="what-it-does">
      <h2>What it does?</h2>
      <div class="info-columns">
        <div class="info-box">
          <p>
            <strong>TUSBinRight++</strong> helps you save time, money and reduce contamination.
            It also helps your residents work out what to recycle where. The scanning process
            feels modern and engaging, improving app usability and satisfaction.
            Encourages repeated use of the platform.
          </p>
        </div>
        <div class="info-box">
          <p>
            Scanning ensures precise item recognition, reducing human error from spelling mistakes
            or incorrect item names. Leads to more accurate waste categorization and cleaner
            recycling streams. Helps users learn proper waste disposal habits by providing
            immediate, reliable feedback.
          </p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router"; // ✅ import router

const router = useRouter();

// ✅ Navigate to SearchItems page
const goToSearchItems = () => {
  router.push("/search-items");
};
</script>

<style scoped>
.home-page {
  font-family: Arial, sans-serif;
  text-align: center;
}

/* Hero Section */
.hero {
  background: url("../images/rethink.jpg") center/cover no-repeat;
  color: white;
  padding: 100px 20px;
  position: relative;
}

.hero-content {
  background-color: rgba(0, 0, 0, 0.55);
  display: inline-block;
  padding: 30px;
  border-radius: 10px;
}

.hero-buttons {
  margin-top: 20px;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  margin: 5px;
  color: white;
}

.how-btn {
  background-color: #4caf50;
}

.scan-btn {
  background-color: #2c7a7b;
}

/* Info Sections */
.info-section,
.what-it-does {
  padding: 40px 20px;
}

.info-columns {
  display: flex;
  justify-content: center;
  gap: 40px;
  flex-wrap: wrap;
  margin-top: 20px;
}

.info-box {
  max-width: 400px;
  text-align: left;
}

/* How it works */
.how-section {
  background-color: #93c47d;
  padding: 40px 20px;
  color: black;
}

.steps {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
}

.steps p {
  font-weight: bold;
  margin-top: 10px;
}


</style>
