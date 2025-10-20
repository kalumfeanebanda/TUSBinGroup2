<template>
  <div class="dashboard-container">
    <header class="navbar">
      <div class="logo-section">
        <img src="@/assets/recycle.jpg" alt="TUSBinRight++" class="logo" />
        <h1>TUSBinRight++</h1>
      </div>
      <nav class="nav-links">
        <router-link to="/home">Home</router-link>
        <router-link to="/user">User</router-link>
        <router-link to="/admin">Admin</router-link>
        <router-link to="/menu">Menu</router-link>
        <router-link to="/">Logout</router-link>
      </nav>
    </header>


    <div class="main-content">
      <aside class="sidebar">
        <ul>
          <li>Steps</li>
          <li>Items</li>
          <li>User</li>
          <li>Staff</li>
        </ul>
      </aside>


      <section class="dashboard">
        <h2>Welcome To TUSBinRight Dashboard</h2>
        <div class="card-container">
          <div class="card" style="background-color: #cddc39;">Items</div>
          <div class="card" style="background-color: #8bc34a;">Bins</div>
          <div class="card" style="background-color: #4caf50;">Location</div>
        </div>
      </section>
    </div>


    <footer class="footer">
      <div>
        <p><strong>Contact Us</strong></p>
        <p>Technological University of Shannon</p>
        <p>support@tusbinright.tus.ie | (087) 066 0662</p>
      </div>
      <div>
        <p>© 2025 TUSBinRight++. All rights reserved.</p>
        <p>Develops at Parts of Group 2</p>
      </div>
    </footer>
  </div>
</template>

<style scoped>
.dashboard-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: #fff6f6;
}


.navbar {
  background-color: #8bc34a;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 2rem;
}

.logo-section {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.logo {
  width: 40px;
  border-radius: 50%;
}

.nav-links a {
  color: white;
  text-decoration: none;
  margin-left: 1rem;
  font-weight: bold;
}

.nav-links a:hover {
  text-decoration: underline;
}


.main-content {
  display: flex;
  flex: 1;
}


.sidebar {
  background-color: #4caf50;
  color: white;
  width: 200px;
  padding: 1rem;
}

.sidebar ul {
  list-style: none;
  padding: 0;
}

.sidebar li {
  background-color: #66bb6a;
  margin-bottom: 1rem;
  padding: 0.8rem;
  text-align: center;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
}

.sidebar li:hover {
  background-color: #388e3c;
}


.dashboard {
  flex: 1;
  padding: 2rem;
  text-align: center;
}

.dashboard h2 {
  font-weight: bold;
  margin-bottom: 1.5rem;
}

.card-container {
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.card {
  flex: 1;
  max-width: 200px;
  padding: 1.5rem;
  color: #000;
  font-weight: bold;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}


.footer {
  background-color: #2e7d32;
  color: white;
  text-align: center;
  padding: 1rem;
  font-size: 0.9rem;
}
</style>
