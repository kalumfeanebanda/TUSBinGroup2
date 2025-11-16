<template>
  <div class="home-page">

    <!-- CUSTOM LOGGED-IN NAVBAR -->
    <nav class="navbar-pro">
      <div class="nav-left" @click="router.push('/logged-in-home')">
        <img src="@/assets/TUSBinLogo.jfif" class="nav-logo" />
        <span class="nav-title">TUSBinRight++</span>
      </div>

      <ul class="nav-center">
        <li :class="{ active: current === 'home' }" @click="router.push('/logged-in-home')">Home</li>
        <li :class="{ active: current === 'search' }" @click="router.push('/search-items')">Search Items</li>
        <li :class="{ active: current === 'profile' }" @click="router.push('/user-profile')">Profile</li>
      </ul>

      <div class="nav-right">
        <button class="logout-btn" @click="logout">Logout</button>
      </div>
    </nav>



    <!-- WELCOME USER -->
    <div class="welcome-box-pro">
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

    <!-- What is this section -->
    <section class="info-section">
      <h2>What is this?</h2>
      <div class="info-columns">
        <div class="info-box">
          <p>
            <strong>TUSBinRight++</strong> is a detailed recycling search database with website
            and mobile app including barcode scanning.
          </p>
        </div>
        <div class="info-box">
          <p>
            <strong>TUSBinRight++</strong> helps your residents work out what to recycle where
            using our search tool or mobile scanner.
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
          <p>2. Get instructions</p>
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
            <strong>TUSBinRight++</strong> helps reduce contamination and teaches users proper waste disposal.
          </p>
        </div>
        <div class="info-box">
          <p>
            Barcode scanning ensures precise item recognition for cleaner recycling streams.
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
/* NAVBAR */
/* =======================
   UNIVERSAL LOGGED-IN NAVBAR
   ======================= */
.navbar-pro {
  width: 100%;
  background-color: #1b4332;
  padding: 12px 28px;
  max-width: 100vw;
  overflow-x: hidden;
  box-sizing: border-box;

  display: flex;
  align-items: center;
  justify-content: space-between;

  box-shadow: 0 3px 8px rgba(0,0,0,0.15);
  position: sticky;
  top: 0;
  z-index: 100;

  overflow-x: hidden;       /* 👈 STOPS SCROLLING */
  flex-wrap: nowrap;        /* 👈 FIX: prevents breaking */
}

/* ----- LEFT: Logo + Title ----- */
.nav-left {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  flex-shrink: 0;           /* 👈 Prevents shrinking */
}

.nav-logo {
  height: 42px;
}

.nav-title {
  color: #fff;
  font-size: 1.4rem;
  font-weight: 700;
  letter-spacing: 0.5px;
}

/* ----- CENTER LINKS ----- */
.nav-center {
  list-style: none;
  display: flex;
  justify-content: center;
  gap: 22px;

  flex-grow: 1;             /* 👈 MAIN FIX - elastic space */
  min-width: 0;             /* 👈 ALLOWS shrinking safely */
}

.nav-center li {
  color: white;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 500;

  padding: 6px 12px;
  border-radius: 8px;

  white-space: nowrap;      /* 👈 Stops wrapping */
  transition: 0.25s ease;
}

.nav-center li:hover,
.nav-center .active {
  background-color: #2d6a4f;
  font-weight: 600;
}

/* ----- RIGHT: Logout Button ----- */
.nav-right {
  flex-shrink: 0;           /* 👈 Prevents overflow */
}

.logout-btn {
  background-color: #d00000;
  border: none;

  padding: 6px 12px;        /* 👈 Slimmer, fits better */
  font-size: 0.9rem;

  border-radius: 6px;
  color: white;
  font-weight: 600;
  cursor: pointer;
  white-space: nowrap;

  transition: 0.25s ease;
}

.logout-btn:hover {
  background-color: #900000;
}

/* GLOBAL FIX to prevent ANY page scroll */
:host, .home-page, body, html {
  overflow-x: hidden !important;
}


/* PAGE STYLES */
.home-page {
  font-family: Arial, sans-serif;
  text-align: center;
}

.welcome-box {
  margin-top: 15px;
  font-size: 1.2rem;
  color: #2d6a4f;
}

/* HERO SECTION */
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
  background-color: rgba(0,0,0,0.6);
  position: absolute;
  width: 100%;
  height: 100%;
}

.hero-content {
  z-index: 2;
}

.btn {
  padding: 10px 20px;
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
}
</style>
