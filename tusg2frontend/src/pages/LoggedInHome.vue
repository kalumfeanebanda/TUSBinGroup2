<template>
  <div class="home-page">

    <!-- CUSTOM HEADER ONLY FOR LOGGED-IN USERS -->
    <header class="header">
      <div class="header-left" @click="router.push('/')">
        <img src="@/assets/TUSBinLogo.jfif" class="logo" alt="Logo" />
        <h1 class="brand">TUSBin</h1>
      </div>

      <div class="header-center">
        <router-link to="/" class="nav-link">HOME</router-link>
        <router-link to="/search-items" class="nav-link">SEARCH ITEMS</router-link>
      </div>

      <div class="header-right">
        <router-link to="/user-profile" class="btn login-btn">PROFILE</router-link>
        <button @click="logout" class="btn logout-btn">LOG OUT</button>
      </div>
    </header>

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
/* ------------------ CUSTOM HEADER ------------------ */
.header {
  background-color: #066502;
  color: white;
  padding: 0.8rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid #a5d6a7;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
}

.logo {
  height: 50px;
  object-fit: contain;
}

.brand {
  font-size: 1.7rem;
  margin: 0;
  font-weight: bold;
}

.header-center {
  display: flex;
  gap: 1.5rem;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-weight: bold;
}

.nav-link:hover {
  color: #a5d6a7;
}

.header-right {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.btn {
  color: white;
  padding: 0.4rem 0.9rem;
  border-radius: 4px;
  text-decoration: none;
  border: none;
  cursor: pointer;
  font-weight: bold;
}

.login-btn {
  background-color: #2e7d32;
}

.login-btn:hover {
  background-color: #388e3c;
}

.logout-btn {
  background-color: #b00000;
}

.logout-btn:hover {
  background-color: #800000;
}

/* ------------------ Existing Styles ------------------ */
.home-page {
  font-family: Arial, sans-serif;
  text-align: center;
}

.welcome-box {
  margin-top: 15px;
  font-size: 1.2rem;
  color: #2d6a4f;
}

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
