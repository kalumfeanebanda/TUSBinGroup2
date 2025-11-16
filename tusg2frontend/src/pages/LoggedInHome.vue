<template>
  <div class="home-page">

    <!-- GLOBAL NAVBAR (Header.vue) -->
    <Header />

    <!-- WELCOME USER -->
    <div class="welcome-box">
      <p>Hello, <strong>{{ user.fname }} {{ user.lname }}</strong> 👋</p>
    </div>

    <!-- Hero Section -->
    <section class="hero">
      <div class="overlay">
        <div class="hero-content">
          <h1>Dispose Right with TUSBinRight++</h1>
          <p>Find the right bin for your taste</p>
          <div class="hero-buttons">
            <button class="btn how-btn">How it works</button>
            <button class="btn scan-btn" @click="goToSearchItems">Scan Now</button>
          </div>
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
            Our simple recycling search tool via website or mobile (barcode scanning included).
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
            Helps users learn proper waste disposal habits with immediate, reliable feedback.
          </p>
        </div>
        <div class="info-box">
          <p>
            Scanning ensures precise item recognition and reduces mistakes.
            Leads to cleaner recycling streams and better sustainability.
          </p>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import Header from "@/components/Header.vue";   // <-- Make sure this is correct!

const router = useRouter();
const user = ref({ fname: "", lname: "" });

onMounted(() => {
  const saved = localStorage.getItem("loggedUser");
  if (saved) {
    user.value = JSON.parse(saved);
  } else {
    router.push("/login");
  }
});

const goToSearchItems = () => {
  router.push("/search-items");
};
</script>

<style scoped>
.home-page {
  font-family: Arial, sans-serif;
  text-align: center;
}

/* Welcome User */
.welcome-box {
  margin-top: 15px;
  font-size: 1.2rem;
  color: #2d6a4f;
}

/* Hero Section */
.hero {
  background: url("../images/BG.jpg") center/cover no-repeat;
  height: 72vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.overlay {
  background-color: rgba(0, 0, 0, 0.6);
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-content {
  text-align: center;
  z-index: 2;
  padding: 30px;
  border-radius: 10px;
}

.hero-content h1 {
  font-size: 2.5rem;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  color: white;
  cursor: pointer;
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
