<template>
  <footer class="footer">
     <!-- top of menu -->
    <div class="footer-top">
      <div class="grid">
        <!-- menu -->
        <section class="col">
          <h3 class="title">Menu</h3>
          <nav class="links">
            <RouterLink to="/" class="link">Home</RouterLink>
            <RouterLink to="/search" class="link">Search Items</RouterLink>
            <RouterLink to="/admin" class="link">Admin Centre</RouterLink>
          </nav>
        </section>

        <!--Contact -->
        <section class="col">
          <h3 class="title">Contact Us</h3>
          <ul class="contact">
            <li>Technological University of Shannon</li>
            <li><a class="link" href="mailto:support@tusbinright.tus.ie">support@tusbinright.tus.ie</a></li>
            <li><a class="link" href="tel:+353870660662">(087) 066 0662</a></li>
          </ul>
        </section>
      </div>

      <!-- social media -->
      <div class="socials" aria-label="Social links">
        <a class="icon" href="#" aria-label="Instagram" v-html="icons.instagram"></a>
        <a class="icon" href="#" aria-label="LinkedIn"  v-html="icons.linkedin"></a>
        <a class="icon" href="#" aria-label="X (Twitter)" v-html="icons.x"></a>
      </div>
    </div>

    <!-- Copyright -->
    <div class="footer-bottom">
      <p>© {{ year }} TUSBinRight+. All rights reserved. Develops at Parts of Group 2</p>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'

const year = computed(() => new Date().getFullYear())

const icons = {
  instagram: `<svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2A3 3 0 0 0 4 7v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm5 3.5a5.5 5.5 0 1 1 0 11 5.5 5.5 0 0 1 0-11zm0 2a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7zm6-1.75a.75.75 0 1 1 0 1.5.75.75 0 0 1 0-1.5z"/></svg>`,
  linkedin: `<svg viewBox="0 0 24 24"><path d="M20.45 20.45h-3.56v-5.6c0-1.34-.02-3.05-1.86-3.05-1.86 0-2.14 1.45-2.14 2.95v5.7H9.33V9h3.41v1.56h.05c.47-.89 1.62-1.83 3.33-1.83 3.56 0 4.22 2.34 4.22 5.38v6.35zM5.34 7.44a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.13 20.45H3.55V9h3.58v11.45z"/></svg>`,
  x: `<svg viewBox="0 0 24 24"><path d="M18.2 2H21l-6.25 7.15L22 22h-5.9l-4.6-6-5.3 6H3.4l6.7-7.6L2 2h6.1l4.2 5.6L18.2 2zm-2.07 18h1.7L7.97 4h-1.8l10 16z"/></svg>`
}
</script>

<style scoped>
.footer {
  width: 100%;
  background: linear-gradient(180deg, #2e7d32 0%, #2b6f2e 60%, #2b6f2e 60%);
  color: #e9f5ea;
  border-radius: 6px;
  margin: 0 auto;
}

.footer-top {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 1rem;
  align-items: start;
  padding: 1rem 1.25rem;
}

.grid {
  display: grid;
  gap: 1rem;
  grid-template-columns: 1fr 1fr;
}

.col .title {
  font-size: 0.95rem;
  font-weight: 700;
  margin-bottom: 0.4rem;
}

.links, .contact { list-style: none; padding: 0; margin: 0; }
.link, .contact a { color: #e9f5ea; text-decoration: none; }
.link:hover, .contact a:hover { text-decoration: underline; }
.links .link,
.contact li { display: block; padding: 0.2rem 0; font-size: 0.95rem; }


.socials {
  display: flex; gap: 0.9rem; align-items: center; justify-self: end;
}
.icon { display: inline-flex; width: 24px; height: 24px; }
.icon svg { width: 24px; height: 24px; fill: #e9f5ea; opacity: .9; }
.icon:hover svg { opacity: 1; }


.footer-bottom {
  background: #63a35c;
  color: #0f2e12;
  padding: 0.6rem 1.25rem;
  font-size: 0.95rem;
  text-align: center;
  border-bottom-left-radius: 6px;
  border-bottom-right-radius: 6px;
}


@media (max-width: 700px) {
  .footer-top { grid-template-columns: 1fr; }
  .socials { justify-self: start; }
}
</style>
