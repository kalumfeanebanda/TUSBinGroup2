<template>
  <section class="container">
    <h2 class="title">Welcome to Our Project</h2>
    <p>Kalum</p>




    <p>tester</p>

    <p>favour</p>

    <p class="lead">
      A quick landing page to introduce what we’re building.
    </p>np

    <div class="cta-row">
      <button class="btn" @click="go()">Get Started</button>
    </div>
  </section>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter?.() // works even if router isn’t installed yet


</script>

<style scoped>
.container { max-width: 900px; margin: 0 auto; padding: 2rem 1rem; text-align: center; }
.title { font-size: 2rem; margin-bottom: 0.5rem; }
.lead { font-size: 1.1rem; color: #444; margin-bottom: 1.25rem; }
.cta-row { display: flex; justify-content: center; gap: 0.75rem; }
.btn { padding: 0.6rem 1rem; border: none; border-radius: 8px; cursor: pointer; background: #16a34a; color: #fff; }
.btn:hover { filter: brightness(0.95); }
</style>
