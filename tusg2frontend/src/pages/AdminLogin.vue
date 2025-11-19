<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-form">
        <h2 class="title">Welcome Admin!</h2>
        <p class="subtitle">Enter your credentials to access the admin dashboard</p>

        <!-- Using v-on:submit and handling preventDefault in the JS function -->
        <form v-on:submit="handleLogin">
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
import axios from 'axios'

const email = ref('')
const password = ref('')
const showPassword = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const router = useRouter()


const API_URL = "/api/admin/login";


const handleLogin = async (e) => {
  e.preventDefault();

  errorMessage.value = '';
  successMessage.value = '';

  if (!email.value || !password.value) {
    errorMessage.value = "Please enter both email and password.";
    return;
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
        }
    )

    if (response.data.status === 'ok') {
      const admin = response.data.admin
      localStorage.setItem('loggedAdmin', JSON.stringify(admin))

      successMessage.value = 'Admin Login successful! Redirecting...'
      console.log('Logged-in admin:', admin)

      setTimeout(() => {
        router.push('/admindashboard');
      }, 1200);

    } else {
      errorMessage.value = response.data.message || 'Login failed. Please try again.'
    }

  } catch (err) {
    console.error('❌ Admin Login Error:', err)
    errorMessage.value =
        err.response?.data?.message ||
        err.response?.data?.messages?.error ||
        'Network or Server Error. Check that XAMPP/WAMP is running and the URL is correct.'
  }
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

***

### **Final Instructions for Testing**

1.  **Replace ALL THREE FILES** with the code provided above.
2.  Ensure your **XAMPP/WAMP/PHP server** is running.
3.  Ensure your **Vue development server (`npm run dev`)** is running.
4.  Log in using a known-good user from your database, for example:
* **Email:** `Kalum@gmail.com`
* **Password:** `Kalum123` (Assuming this is the plain-text password)

This combination of fixes (correct route mapping, guaranteed CORS headers, and robust URL) should finally allow CodeIgniter to find the `Admin` class. Please let me know the status code you get now (200 OK, 401 Unauthorized, or 500 Server Error).