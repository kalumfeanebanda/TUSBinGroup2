<template>
  <div class="register-container">
    <div class="register-card">
      <div class="register-form">
        <h2 class="title">Create an Account</h2>
        <p class="subtitle">GET STARTED NOW!</p>

        <form @submit.prevent="handleRegister">
          <label>Full Name</label>
          <input
              v-model="name"
              type="text"
              placeholder="Enter your full name"
              required
          />

          <label>Email</label>
          <input
              v-model="email"
              type="email"
              placeholder="Enter your email"
              required
          />

          <label>Password</label>
          <input
              v-model="password"
              type="password"
              placeholder="Enter your password"
              required
          />

          <label>Retype Password</label>
          <input
              v-model="confirmPassword"
              type="password"
              placeholder="Re-enter your password"
              required
          />


          <button type="submit" class="register-btn">Sign Up</button>
        </form>


        <div class="login-section">
          <p>Already have an account?</p>
          <router-link to="/login">
            <button class="small-login-btn">Login</button>
          </router-link>
        </div>
      </div>


      <div class="register-image">
        <img src="@/assets/recycle.jpg" alt="Recycle" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");

const handleRegister = () => {
  if (password.value !== confirmPassword.value) {
    alert("Passwords do not match!");
    return;
  }

  console.log("Registering:", name.value, email.value);
  alert("Sign Up Successful!");
};
</script>

<style scoped>
.register-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 90vh;
  background:url("../images/BG.jpg");
  padding: 1rem;
}

.register-card {
  display: flex;
  background: #FFF9E0;
  border-radius: 12px;
  box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  max-width: 850px;
  width: 100%;
  align-items: center;
}

.register-form {
  flex: 1;
  max-width: 350px;
  padding: 2rem;
}

.title {
  font-size: 1.8rem;
  font-weight: bold;
  margin-bottom: 0.25rem;
  color: #1b5e20;
}

.subtitle {
  font-size: 0.9rem;
  color: #555;
  margin-bottom: 1.5rem;
}

form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

label {
  font-weight: bold;
  font-size: 0.9rem;
}

input {
  padding: 0.7rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
}


.register-btn {
  background-color: #1b5e20;
  color: white;
  padding: 0.8rem;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  font-size: 1rem;
  cursor: pointer;
  transition: 0.3s;
  width: 100%;
}

.register-btn:hover {
  background-color: #145a17;
}


.login-section {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 1rem;
  font-size: 0.9rem;
  color: #333;
}

.small-login-btn {
  background-color: #2e7d32;
  color: white;
  border: none;
  border-radius: 6px;
  padding: 0.4rem 0.9rem;
  font-size: 0.85rem;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}

.small-login-btn:hover {
  background-color: #1b5e20;
}

.register-image {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
}

.register-image img {
  max-width: 70%;
  height: auto;
  border-radius: 12px;
}
</style>


