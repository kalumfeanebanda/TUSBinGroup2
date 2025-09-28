<script setup>
import home from './pages/home.vue'
import Footer from './components/Footer.vue'
</script>

<template>
  <div class="app">
<<<<<<< Updated upstream
=======


>>>>>>> Stashed changes
    <main class="main">
      <home />
    </main>

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
.app { min-height: 100dvh; display: flex; flex-direction: column; }
.main { flex: 1 1 auto; }
</style>
