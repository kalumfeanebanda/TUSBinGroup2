<template>
  <div class="home-page">

    <!-- NAVBAR FOR LOGGED-IN USER -->
    <nav class="navbar">
      <div class="logo" @click="router.push('/')">
        <img src="../images/logo.png" alt="Logo" />
        <span>TUSBinRight++</span>
      </div>

      <ul class="nav-links">
        <li @click="router.push('/')">Home</li>
        <li @click="router.push('/search-items')">Search Items</li>
        <li @click="router.push('/user-profile')">Profile</li>
        <li class="logout" @click="logout">Logout</li>
      </ul>
    </nav>

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

import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

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

const logout = () => {
  localStorage.removeItem("loggedUser");
  router.push("/login");
};

const goToSearchItems = () => {
  router.push("/search-items");
};

</script>

<style scoped>
.home-page {
  font-family: Arial, sans-serif;
  text-align: center;
}


.navbar {
  background-color: #2d6a4f;
  color: white;
  padding: 15px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
}

.logo img {
  height: 45px;
}

.logo span {
  font-weight: bold;
  font-size: 1.4rem;
}

.nav-links {
  display: flex;
  list-style: none;
  gap: 22px;
}

.nav-links li {
  cursor: pointer;
  padding: 6px 12px;
  border-radius: 6px;
}

.nav-links li:hover {
  background-color: #40916c;
}

.logout {
  background-color: #d00000;
}

.logout:hover {
  background-color: #a00000;
}

/* Welcome User */
.welcome-box {
  margin-top: 15px;
  font-size: 1.2rem;
  color: #2d6a4f;
}

/* Existing homepage styling below */
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

/* Info sections remain the same */
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
