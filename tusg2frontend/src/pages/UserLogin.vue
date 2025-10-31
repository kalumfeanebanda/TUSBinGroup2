<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-form">
        <h2 class="title">Welcome Back</h2>
        <p class="subtitle">LOG IN TO YOUR ACCOUNT</p>

        <form @submit.prevent="handleLogin">
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

          <button type="submit" class="login-btn">Log In</button>
        </form>

        <p v-if="successMessage" class="success-msg">{{ successMessage }}</p>
        <p v-if="errorMessage" class="error-msg">{{ errorMessage }}</p>

        <div class="register-section">
          <p>Don't have an account?</p>
          <router-link to="/register">
            <button class="small-register-btn">Sign Up</button>
          </router-link>
        </div>
      </div>

      <div class="login-image">
        <img src="@/assets/recycle.jpg" alt="Recycle" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const email = ref("");
const password = ref("");
const successMessage = ref("");
const errorMessage = ref("");

const handleLogin = async () => {
  // --- Client-Side Validation (Minimal for Login) ---
  if (!email.value || !password.value) {
    errorMessage.value = "Please enter both email and password.";
    successMessage.value = "";
    return;
  }

  // Clear previous messages
  errorMessage.value = "";
  successMessage.value = "";

  try {
    const response = await axios.post("http://localhost:8081/api/login", {
      email: email.value,
      password: password.value,
    });

    if (response.data.status === "ok") {
      // Assuming the API returns a token or user data on success
      successMessage.value = "Login successful! Redirecting...";

      // TODO: Store the authentication token/session data here
      // Example: localStorage.setItem('userToken', response.data.token);

      setTimeout(() => {
        // Redirect to a dashboard or home page
        router.push("/dashboard");
      }, 1500);
    } else {
      // The server returned a 200 OK but with status: 'error'
      errorMessage.value = response.data.message || "Login failed.";
    }
  } catch (err) {
    // Handle HTTP errors (e.g., 400 Bad Request, 500 Server Error)
    console.error("Login Error:", err);
    errorMessage.value =
        err.response?.data?.message || "Invalid credentials or server error. Please try again.";
  }
};
</script>

<style scoped>
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


