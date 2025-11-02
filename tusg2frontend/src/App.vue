<script setup>
import { useRoute } from 'vue-router'
import { computed } from 'vue'



// Bring in the header and footer
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'

// Get the current route info
const route = useRoute()

// Hide layout on admin dashboard page only
const hideLayout = computed(() => route.path === '/admindashboard', '/items')
</script>

<template>
  <div class="app">

    <!-- Header only if NOT admindashboard -->
    <Header v-if="!hideLayout" />

    <main class="main">
      <router-view />
    </main>

    <!-- Footer only if NOT admindashboard -->
    <Footer
        v-if="!hideLayout"
        projectName="Bin Pro"
        orgName="Your College"
        :links="[
        { label: 'About', href: '/about' },
        { label: 'Contact', href: '/contact' }
      ]"
    />
  </div>
</template>

<style scoped>
.app {
  min-height: 100dvh;
  display: flex;
  flex-direction: column;
}

.main {
  flex: 1 1 auto;
}
</style>
