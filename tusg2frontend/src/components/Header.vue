<template>
  <header class="header">
    <div class="header-inner">
      <!-- Logo -->
      <div class="logo">
        <img src="@/assets/TUSBinLogo.jfif" alt="TUSBin Logo" class="logo-img" />
        <h1 class="logo-text">TUSBin</h1>
      </div>

      <!-- Nav links beside logo -->
      <nav class="nav-links">
        <router-link to="/" class="nav-link" exact-active-class="active">HOME</router-link>
        <router-link to="/search-items" class="nav-link" exact-active-class="active">SEARCH ITEMS</router-link>
      </nav>

      <!-- Search + Login/Register -->
      <div class="actions">
        <input
            type="text"
            v-model="searchQuery"
            placeholder="Search"
            class="search-bar"
            @keypress.enter="performSearch"
        />
        <router-link to="/login" class="action-btn login-btn">LOG IN</router-link>
        <router-link to="/register" class="action-btn register-btn">REGISTER</router-link>
      </div>

      <!-- Mobile toggle -->
      <button class="menu-toggle" @click="toggleMobileMenu">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <!-- Mobile dropdown -->
    <div class="mobile-menu" v-if="isMobileMenuOpen">
      <router-link to="/" class="nav-link" @click="toggleMobileMenu">HOME</router-link>
      <router-link to="/search-items" class="nav-link" @click="toggleMobileMenu">SEARCH ITEMS</router-link>
      <router-link to="/login" class="nav-link" @click="toggleMobileMenu">LOG IN</router-link>
      <router-link to="/register" class="nav-link" @click="toggleMobileMenu">REGISTER</router-link>
    </div>
  </header>
</template>

<script>
import { useRouter } from "vue-router";

export default {
  name: "Header",
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
.header {
  background-color: #066502;
  color: white;
  padding: 0.8rem 2rem;
  border-bottom: 2px solid #a5d6a7;
  position: relative;
}

.header-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
}

/* Logo */
.logo {
  display: flex;
  align-items: center;
  gap: 10px;
}
.logo-img {
  height: 55px;
  width: auto;
  object-fit: contain;
}
.logo-text {
  font-weight: bold;
  font-size: 2rem;
}

/* Nav Links beside logo */
.nav-links {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  margin-left: 1rem;
}
.nav-link {
  color: white;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s;
}
.nav-link:hover,
.nav-link.active {
  color: #a5d6a7;
}

/* Right Side Actions */
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
  padding: 0.4rem 0.8rem;
}
.search-bar:focus {
  outline: none;
  border-color: #a5d6a7;
}

/* Buttons beside search bar */
.action-btn {
  text-decoration: none;
  color: white;
  font-weight: bold;
  border-radius: 4px;
  padding: 0.4rem 0.9rem;
  transition: background 0.3s;
}
.login-btn {
  background-color: #2e7d32;
}
.login-btn:hover {
  background-color: #388e3c;
}
.register-btn {
  background-color: #6baa75;
}
.register-btn:hover {
  background-color: #81c784;
}

/* Mobile */
.menu-toggle {
  display: none;
  background: none;
  border: none;
  color: white;
  font-size: 1.5rem;
  cursor: pointer;
}

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
.mobile-menu .nav-link {
  color: white;
}

@media (max-width: 768px) {
  .nav-links,
  .actions {
    display: none;
  }
  .menu-toggle {
    display: block;
  }
  .logo-text {
    font-size: 1.5rem;
  }
}
</style>
