<script setup>
// Bring in the header and footer, they stay the same on every page
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
</script>

<template>
  <div class="app">
    <!-- Top of the site -->
    <Header/>

    <!-- The main content changes depending on the route -->
    <main class="main">
      <!-- This is the "screen" where pages load -->
      <router-view />
    </main>

    <!-- Bottom of the site -->
    <Footer
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
  min-height: 100dvh; /* take full screen height */
  display: flex;
  flex-direction: column; /* stack header, main, footer */
}

.main {
  flex: 1 1 auto; /* main area grows/shrinks as needed */
}
</style>

