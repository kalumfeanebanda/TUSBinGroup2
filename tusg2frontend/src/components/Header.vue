<template>
  <header class="testing-header">
    <!-- Left: Logo -->
    <div class="logo">
      <img src="@/assets/TUSBinLogo.jfif" alt="TUSBin Logo" class="logo-img" />
      <span class="logo-text">TUSBin</span>
    </div>

    <!-- Center: Navigation Links -->
    <nav class="nav-links">
      <router-link to="/" class="nav-link" exact-active-class="active">HOME</router-link>
      <router-link to="/Search" class="nav-link" exact-active-class="active">SEARCH ITEMS</router-link>
      <router-link to="/contactus" class="nav-link" exact-active-class="active">CONTACT US</router-link>
    </nav>

    <!-- Right: Search & Auth Links -->
    <div class="actions">
      <input
          type="text"
          v-model="searchQuery"
          placeholder="Search"
          class="search-bar"
          @keypress.enter="performSearch"
      />
      <router-link to="/signin" class="nav-link">LOG IN</router-link>
      <router-link to="/signup" class="nav-link">REGISTER</router-link>
    </div>

    <!-- Mobile Toggle -->
    <button class="menu-toggle" @click="toggleMobileMenu">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile Menu -->
    <div class="mobile-menu" v-if="isMobileMenuOpen">
      <router-link to="/" class="nav-link" @click="toggleMobileMenu">HOME</router-link>
      <router-link to="/Search" class="nav-link" @click="toggleMobileMenu">SEARCH ITEMS</router-link>
      <router-link to="/contactus" class="nav-link" @click="toggleMobileMenu">CONTACT US</router-link>
      <router-link to="/login" class="nav-link" @click="toggleMobileMenu">LOG IN</router-link>
      <router-link to="/register" class="nav-link" @click="toggleMobileMenu">REGISTER</router-link>
    </div>
  </header>
</template>

<script>
import { useRouter } from "vue-router";

export default {
  name: "NavBar",
  data() {
    return {
      isMobileMenuOpen: false,
      searchQuery: "",
    };
  },
  setup() {
    useRouter();
    const performSearch = () => {
      // Add search logic if needed
    };
    return { performSearch };
  },
  methods: {
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen;
    },
  },
};
</script>

<style scoped>
.testing-header {
  background-color: #1b5e20; /* dark green */
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  border-bottom: 2px solid #a5d6a7;
  flex-wrap: wrap;
}

/* Left: Logo */
.logo {
  display: flex;
  align-items: center;
  gap: 15px;
}

.logo-img {
  height: 60px;
  width: auto;
  object-fit: contain;
}

.logo-text {
  font-weight: bold;
  font-size: 2rem;
}

/* Center: Navigation */
.nav-links {
  display: flex;
  gap: 2rem;
  flex: 1;
  justify-content: center;
  align-items: center;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-weight: bold;
  font-size: 1rem;
  transition: color 0.3s;
}

.nav-link:hover,
.nav-link.active {
  color: #a5d6a7;
}

/* Right: Search and auth links */
.actions {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.search-bar {
  background-color: #2e7d32;
  color: white;
  border: 1px solid #145a17;
  border-radius: 5px;
  padding: 0.5rem 0.75rem;
}

.search-bar:focus {
  outline: none;
  border-color: #a5d6a7;
}

/* Mobile toggle */
.menu-toggle {
  display: none;
  background: none;
  border: none;
  color: white;
  font-size: 1.5rem;
  cursor: pointer;
}

/* Mobile menu */
.mobile-menu {
  width: 100%;
  background-color: #145a17;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1rem 0;
  gap: 1rem;
  border-top: 1px solid #2e7d32;
}

/* Responsive */
@media (max-width: 768px) {
  .nav-links,
  .actions {
    display: none;
  }
  .menu-toggle {
    display: block;
  }
  .logo-img {
    height: 50px;
  }
  .logo-text {
    font-size: 1.5rem;
  }
}
</style>