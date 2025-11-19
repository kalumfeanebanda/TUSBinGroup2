<template>
  <div class="profile-page">


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


    <!-- USER PROFILE CONTAINER -->
    <div class="profile-container">
      <h1 class="title">User Profile</h1>

      <div class="profile-card">

        <!-- LEFT SIDE: Avatar + Edit Button -->
        <div class="profile-left">
          <div class="avatar"></div>
          <button class="edit-btn">Edit Profile</button>
        </div>

        <!-- RIGHT SIDE: User Info -->
        <div class="profile-info">
          <p><strong>Name:</strong> {{ user.fname }} {{ user.lname }}</p>
          <p><strong>Email:</strong> {{ user.email }}</p>
        </div>

      </div>

      <!-- ACTION CARDS -->
      <div class="actions">
        <div class="action-card">
          <img src="../images/search-icon.png" alt="Search" />
          <h3>My Search History</h3>
          <p>View items you searched</p>
        </div>

        <div class="action-card">
          <img src="../images/check-icon.png" alt="Suggestions" />
          <h3>My Suggestions</h3>
          <p>View your suggestions</p>
        </div>

        <div class="action-card">
          <img src="../images/location-icon.png" alt="Location" />
          <h3>My Location Preference</h3>
          <p>Set your location</p>
        </div>
      </div>
    </div>


    <footer class="home-footer">
      <p>© 2025 TUSBinRight++ | All Rights Reserved</p>
    </footer>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const user = ref({ fname: "", lname: "", email: "" });

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
</script>

<style scoped>

/* =======================
   UNIVERSAL LOGGED-IN NAVBAR
   ======================= */
.navbar-pro {
  box-sizing: border-box;
  width: 100%;
  background-color: #1b4332;
  padding: 12px 28px;
  max-width: 100vw;

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
:host, .profile-page, body, html {
  overflow-x: hidden !important;
}


/* PAGE CONTAINER */
.profile-page {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
  min-height: 100vh;
}

/* TITLE */
.title {
  margin-top: 40px;
  text-align: center;
  font-size: 2rem;
  color: #2d6a4f;
}

/* PROFILE CARD */
.profile-card {
  max-width: 750px;
  margin: 30px auto;
  padding: 25px;
  display: flex;
  align-items: center;
  gap: 40px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.15);
  flex-wrap: wrap;
}

.profile-left {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.avatar {
  width: 130px;
  height: 130px;
  background-color: #d9d9d9;
  border-radius: 50%;
  margin-bottom: 15px;
}

.edit-btn {
  background-color: #4caf50;
  color: white;
  padding: 8px 20px;
  border-radius: 20px;
  border: none;
  cursor: pointer;
}

.edit-btn:hover {
  background-color: #3c8c42;
}

.profile-info {
  font-size: 1rem;
  text-align: left;
  color: #333;
}

.profile-info p {
  margin-bottom: 10px;
}

/* ACTION CARDS */
.actions {
  display: flex;
  justify-content: center;
  gap: 40px;
  flex-wrap: wrap;
  margin-top: 30px;
}

.action-card {
  width: 220px;
  background: white;
  padding: 20px;
  border-radius: 14px;
  box-shadow: 0 3px 12px rgba(0,0,0,0.15);
  transition: 0.2s;
  text-align: center;
}

.action-card:hover {
  transform: translateY(-5px);
}

.action-card img {
  height: 45px;
  margin-bottom: 10px;
}

.action-card h3 {
  color: #2c7a7b;
  margin-bottom: 6px;
}

.home-footer {
  margin-top: 60px;
  padding: 20px 0;
  background-color: #2d6a4f;
  color: white;
  text-align: center;
}
</style>
