<template>
  <div class="profile-page">


    <nav class="navbar">
      <div class="logo" @click="router.push('/logged-in-home')">
        <img src="@/assets/TUSBinLogo.jfif" alt="Logo" />
        <span>TUSBinRight++</span>
      </div>

      <ul class="nav-links">
        <li @click="router.push('/logged-in-home')">Home</li>
        <li @click="router.push('/search-items')">Search Items</li>
        <li class="active">Profile</li>
        <li class="logout" @click="logout">Logout</li>
      </ul>
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

.navbar {
  background-color: #2d6a4f;
  color: white;
  padding: 15px 35px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.logo img {
  height: 45px;
  margin-right: 10px;
}

.logo span {
  font-size: 1.4rem;
  font-weight: bold;
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 22px;
  font-size: 1rem;
}

.nav-links li {
  padding: 8px 14px;
  cursor: pointer;
  border-radius: 6px;
  transition: 0.2s;
}

.nav-links li:hover,
.nav-links .active {
  background-color: #40916c;
}

.logout {
  background-color: #d00000;
}

.logout:hover {
  background-color: #a00000;
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
