<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-form">
        <h2 class="title">Welcome!</h2>
        <p class="subtitle">Enter your Credentials to access your account</p>

        <form @submit.prevent="handleLogin">
          <label>Email</label>
          <input v-model="email" type="email" placeholder="Enter your email" required />

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

          <button type="submit" class="login-btn">Login</button>
        </form>

        <p v-if="successMessage" class="message success-msg">{{ successMessage }}</p>
        <p v-if="errorMessage" class="message error-msg">{{ errorMessage }}</p>

        <router-link to="/adminlogin">
          <button class="admin-login-btn">Admin Login</button>
        </router-link>

        <p class="register-text">
          Not Registered yet?
          <router-link to="/register" class="register-link">Register Here</router-link>
        </p>
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
import axios from 'axios'

const router = useRouter()
const email = ref('')
const password = ref('')
const showPassword = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

// Correct API endpoint
const API_URL = 'http://localhost/TUSBinGroup2/BinBackendG2/public/index.php/api/users/login'


const handleLogin = async () => {
  errorMessage.value = ''
  successMessage.value = ''

  if (!email.value || !password.value) {
    errorMessage.value = 'Please enter both email and password.'
    return
  }

  try {
    const response = await axios.post(
        API_URL,
        {
          email: email.value.trim(),
          password: password.value.trim(),
        },
        {
          headers: { 'Content-Type': 'application/json' },
          withCredentials: true,
        }
    )

    if (response.data.status === 'ok') {
      const user = response.data.user

      // SAVE USER DATA IN LOCALSTORAGE
      localStorage.setItem('loggedUser', JSON.stringify(user))

      successMessage.value = 'Login successful! Redirecting...'
      console.log('Logged-in user:', user)

      setTimeout(() => {
        router.push('/logged-in-home') // Redirect to user homepage
      }, 1200)

    } else {
      errorMessage.value = response.data.message || 'Login failed. Please try again.'
    }

  } catch (err) {
    console.error('❌ Login Error:', err)
    errorMessage.value =
        err.response?.data?.message ||
        err.response?.data?.messages?.error ||
        'Invalid credentials or server error. Please try again.'
  }
}

const togglePassword = () => {
  showPassword.value = !showPassword.value
}
</script>

<style scoped>
/* Layout styling */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 90vh;
  background: url("../images/BG.jpg");
  padding: 1rem;
}

.login-card {
  display: flex;
  background: #fff9e0;
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

/* Typography */
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

/* Form styling */
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

/* Buttons */
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

.admin-login-btn {
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

.admin-login-btn:hover {
  background-color: #7f0000;
}

/* Register link */
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

/* Image */
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

/* Feedback messages */
.message {
  padding: 0.75rem;
  margin-top: 1rem;
  border-radius: 6px;
  font-weight: bold;
  font-size: 0.9rem;
  text-align: center;
}

.success-msg {
  background-color: #e8f5e9;
  color: #1b5e20;
  border: 1px solid #1b5e20;
}

.error-msg {
  background-color: #ffebee;
  color: #b71c1c;
  border: 1px solid #b71c1c;
}
</style>
