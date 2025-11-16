<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-form">
        <h2 class="title">Welcome Admin!</h2>
        <p class="subtitle">Enter your credentials to access the admin dashboard</p>

        <form @submit.prevent="handleLogin">
          <label>Email</label>
          <input
              v-model="email"
              type="email"
              placeholder="Enter admin email"
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

          <router-link
              to="/forgot-password"
              style="display: block; margin: 0.5rem 0 1rem; font-size: 0.85rem; color: #1b5e20; text-decoration: underline;"
          >
            Forgot Password?
          </router-link>


          <button type="submit" class="login-btn">Login as Admin</button>

          <p v-if="successMessage" class="message success-msg">{{ successMessage }}</p>
          <p v-if="errorMessage" class="message error-msg">{{ errorMessage }}</p>
          <router-link to="/login">
            <button type="button" class="back-btn">Back to User Login</button>
          </router-link>
        </form>
      </div>


      <div class="login-image">
        <img src="@/assets/recycle.jpg" alt="Recycle" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
// AXIOS REMOVED

const email = ref('')
const password = ref('')
const showPassword = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const router = useRouter()

const handleLogin = async () => {
  // Clear previous messages
  errorMessage.value = ''
  successMessage.value = ''

  if (!email.value || !password.value) {
    errorMessage.value = "Please enter both email and password."
    return
  }

  // ----------------------------------------------------
  // CLIENT-SIDE BYPASS: ALWAYS SUCCEEDS FOR NOW
  // ----------------------------------------------------

  // 1. Success Message
  successMessage.value = "Admin Login successful! Redirecting (Bypass Mode)..."

  // 2. Simulate storing an admin ID (Optional, but good practice)
  console.log('Admin ID:', 999)

  // 3. Redirect after a short delay
  setTimeout(() => {
    router.push('/admindashboard') // Redirect to the admin dashboard
  }, 1000)
}

const togglePassword = () => {
  showPassword.value = !showPassword.value
}
</script>

<style scoped>
/* 💡 Added message styles for success/error feedback */
.message {
  padding: 0.75rem;
  margin-top: 1rem;
  border-radius: 6px;
  font-weight: bold;
  font-size: 0.9rem;
  text-align: center;
}

.success-msg {
  background-color: #e8f5e9; /* Light Green */
  color: #1b5e20; /* Dark Green */
  border: 1px solid #1b5e20;
}

.error-msg {
  background-color: #ffebee; /* Light Red */
  color: #b71c1c; /* Dark Red */
  border: 1px solid #b71c1c;
}
/* (Rest of the original styles...) */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 90vh;
  background:url("../images/BG.jpg");
  padding: 1rem;
}

.login-card {
  display: flex;
  background: #FFF9E0;
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
  margin-top: 0.5rem;
  width: 100%;
}

.login-btn:hover {
  background-color: #145a17;
}


.back-btn {
  background-color: #b71c1c;
  color: white;
  padding: 0.8rem;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  font-size: 1rem;
  cursor: pointer;
  transition: 0.3s;
  margin-top: 0.8rem;
  width: 100%;
}

.back-btn:hover {
  background-color: #7f0000;
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