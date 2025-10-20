<template>
  <section class="container">
    <h2 class="title">Dispose Right with TUSBINRight++</h2>
    <h2>Find the right bin for your taste</h2>


    <div class="search-placeholder">
      [ Search bar will go here ]
    </div>
<div class="how-it-works">
     <p class="How">How it works:</p></div>
    <div class="how-it-works-steps">
      <div>


       <router-link to=""> <p class="bigger-text">1.Enter it or scan</p></router-link>

        <img src="../images/glass.png" height="85" width="150"/></div>
      <div>

        <router-link to=""><p class="bigger-text">2.Get disposal result and instructions</p></router-link>

        <img src="../images/result.png" height="85" width="135"/></div>
      <div>

        <router-link to=""><p class="bigger-text">3.Recycle the right way</p></router-link>
        <img src="../images/bin.png" height="85" width="120"/>
      </div>
    </div>
  </section>

</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter?.()


</script>

<style scoped>

.container {
  text-align: center;
  padding: 40px 20px;
  max-width: 1000px;
  margin: 0 auto;
}

.title {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 10px;
}

.subtitle {
  font-size: 18px;
  color: #444;
  margin-bottom: 30px;
}

.search-placeholder {
  width: 60%;
  margin: 0 auto 40px auto;
  padding: 18px;
  border: 2px dashed #aaa;
  border-radius: 8px;
  color: #777;
  font-size: 16px;
}
.bigger-text {
  font-size: 20px;
  font-weight: bold;
}
.how-it-works-steps {
  display: flex;
  justify-content: space-around;
  gap: 20px;
  margin-top: 30px;
  flex-wrap: wrap;
}

.step {
  flex: 1;
  min-width: 200px;
  max-width: 250px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.step img {
  height: 70px;
  width: 72px;
  margin-bottom: 10px;
}

.step p {
  font-size: 16px;
  font-weight: 500;
  color: #333;
}
.How{
  font-size: 27px;
  font-weight: bold;
}
.btn:hover { filter: brightness(0.95); }

</style>
