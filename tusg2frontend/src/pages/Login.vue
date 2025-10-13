<template>
  <div class="login-container">
    <div class="login-card">

      <div class="login-form">
        <h2 class="title">Welcome!</h2>
        <p class="subtitle">Enter your Credentials to access your account</p>

        <form @submit.prevent="handleLogin">
          <label>Email</label>
          <input
              v-model="email"
              type="email"
              placeholder="Enter your email"
              required
          />

          <label>Password</label>
          <div style="position: relative;">
            <input
                v-model="password"
                :type="showPassword ? 'text' : 'password'"
                placeholder="Enter your password"
                required
                style="padding-right: 2.5rem;"
            />
            <span
                @click="togglePassword"
                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"
            >
              {{ showPassword ? '👁' : '👁' }}
            </span>
          </div>

          <router-link to="/forgot-password" style="display: block; margin: 0.5rem 0 1rem; font-size: 0.85rem; color: #1b5e20; text-decoration: underline;">
            Forgot Password?
          </router-link>

          <button type="submit" class="login-btn">Login</button>
        </form>

        <p class="register-text">
          Not Registered yet?
          <router-link to="/register" class="register-link">Register Here</router-link>
        </p>
      </div>

      <!-- Right: Illustration -->
      <div class="login-image">
        <img src="@/assets/recycle.jpg" alt="Recycle" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const email = ref('')
const password = ref('')
const showPassword = ref(false)

const handleLogin = () => {
  console.log('Email:', email.value)
  console.log('Password:', password.value)
}

const togglePassword = () => {
  showPassword.value = !showPassword.value
}
</script>

<style scoped>


.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 90vh;
  background-color: #fff6f6;
  padding: 1rem;
}

.login-card {
  display: flex;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  max-width: 850px;
  width: 100%;
  align-items: center;
}

.login-form {
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

.login-btn {
  background-color: #1b5e20;
  color: white;
  padding: 0.8rem;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  font-size: 1rem;
  cursor: pointer;
  transition: 0.3s;
}

.login-btn:hover {
  background-color: #145a17;
}

.register-text {
  margin-top: 1rem;
  font-size: 0.9rem;
  color: #333;
}

.register-link {
  color: #1b5e20;
  font-weight: bold;
  text-decoration: none;
  margin-left: 0.25rem;
}

.register-link:hover {
  text-decoration: underline;
}

.login-image {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
}

.login-image img {
  max-width: 70%;
  height: auto;
  border-radius: 12px;
}
</style>

