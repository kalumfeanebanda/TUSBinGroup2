<script setup>
import {useRoute} from 'vue-router'
import {computed} from 'vue'

// Bring in the header and footer
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'

// Get the current route info
const route = useRoute()

// Hide HEADER on these pages
const hideLayout = computed(() => {
  return [
    '/admindashboard',
    '/bins',
    '/items',
    '/logged-in-home',
    '/user-profile'// hide global header on logged-in-home
  ].includes(route.path)
})

// Hide FOOTER on these pages
const hideFooter = computed(() => {
  return [
    '/admindashboard',
    '/bins',
    '/items',
    '/user-profile'     // hide global footer on user-profile
  ].includes(route.path)
})
</script>

<template>
  <div class="app">

    <!-- Header only if NOT hidden -->
    <Header v-if="!hideLayout"/>

    <main class="main">
      <router-view/>
    </main>

    <!-- Footer uses hideFooter (fix!) -->
    <Footer
        v-if="!hideFooter"
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
