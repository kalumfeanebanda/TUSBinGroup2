<script setup>
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import home from './pages/home.vue'
import signin from './pages/signin.vue'
import signup from './pages/signup.vue'
</script>

<template>
  <div class="app">


   

 
    <!-- Header (always visible) -->
    <Header/>

    <!-- Main content (page content changes here) -->

 


 


    <main class="main">
      <home/>
      <!-- later replace <home /> with <router-view /> -->

    </main>

    <!-- Footer (always visible) -->
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
  min-height: 100dvh;
  display: flex;
  flex-direction: column;
}

.main {
  flex: 1 1 auto;
}
</style>
