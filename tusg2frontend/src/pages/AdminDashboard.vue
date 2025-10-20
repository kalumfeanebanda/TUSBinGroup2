<template>
  <div class="dashboard-container">
    <header class="navbar">
      <div class="logo-section">
        <img src="@/assets/recycle.jpg" alt="TUSBinRight++" class="logo" />
        <h1 class="title-text">TUSBinRight++</h1>
      </div>

      <nav class="nav-links">
        <router-link to="/">Home</router-link>
        <router-link to="/user">User</router-link>
        <router-link to="/admin">Admin</router-link>
        <router-link to="/menu">Menu</router-link>
        <router-link to="/adminlogin">Logout</router-link>
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
          <div class="card items">Items</div>
          <div class="card bins">Bins</div>
          <div class="card location">Location</div>
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
        <p>Developed by Group 2</p>
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
  background-color: #4caf50;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 2rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.logo-section {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.logo {
  width: 45px;
  border-radius: 50%;
}

.title-text {
  font-size: 1.4rem;
  font-weight: bold;
  letter-spacing: 0.5px;
}

.nav-links a {
  color: white;
  text-decoration: none;
  margin-left: 1.25rem;
  font-weight: bold;
  transition: 0.3s;
}

.nav-links a:hover {
  text-decoration: underline;
  color: #e8f5e9;
}


.main-content {
  display: flex;
  flex: 1;
}


.sidebar {
  background-color: #388e3c;
  color: white;
  width: 220px;
  padding: 1.5rem 1rem;
  border-top-right-radius: 10px;
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sidebar li {
  background-color: #66bb6a;
  margin-bottom: 1rem;
  padding: 0.9rem;
  text-align: center;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
}

.sidebar li:hover {
  background-color: #2e7d32;
  transform: scale(1.05);
}


.dashboard {
  flex: 1;
  padding: 2rem;
  text-align: center;
}

.dashboard h2 {
  font-weight: bold;
  font-size: 1.5rem;
  color: #1b5e20;
  margin-bottom: 2rem;
}

.card-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 1.5rem;
}


.card {
  flex: 1;
  min-width: 180px;
  max-width: 250px;
  padding: 2rem 1rem;
  color: #000;
  font-weight: bold;
  border-radius: 10px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  transition: 0.3s;
}

.card:hover {
  transform: translateY(-5px);
}

.card.items {
  background-color: #cddc39;
}

.card.bins {
  background-color: #8bc34a;
}

.card.location {
  background-color: #4caf50;
}


.footer {
  background-color: #2e7d32;
  color: white;
  text-align: center;
  padding: 1rem;
  font-size: 0.9rem;
  border-top: 3px solid #1b5e20;
}

.footer p {
  margin: 0.2rem 0;
}


@media (max-width: 768px) {
  .main-content {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    border-radius: 0;
    text-align: center;
  }

  .card-container {
    flex-direction: column;
    align-items: center;
  }
}
</style>

