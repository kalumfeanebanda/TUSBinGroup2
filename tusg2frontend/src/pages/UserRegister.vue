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
          <small class="password-hint">
            Must be 8+ chars, 1 uppercase, 1 number & 1 special symbol.
          </small>

          <label>Retype Password</label>
          <input
              v-model="confirmPassword"
              type="password"
              placeholder="Re-enter your password"
              required
          />

          <button type="submit" class="register-btn">Sign Up</button>
        </form>

        <!-- Messages -->
        <p v-if="successMessage" class="success-msg">{{ successMessage }}</p>
        <p v-if="errorMessage" class="error-msg">{{ errorMessage }}</p>

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
import api from "@/lib/api";
import { useRouter } from "vue-router";

const router = useRouter();

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");
const successMessage = ref("");
const errorMessage = ref("");

const validatePassword = () => {
  const regex =
      /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

  if (!regex.test(password.value)) {
    errorMessage.value =
        "Password must be 8+ characters, include 1 uppercase letter, 1 number & 1 special character.";
    successMessage.value = "";
    return false;
  }

  return true;
};




const handleRegister = async () => {
  if (password.value !== confirmPassword.value) {
    errorMessage.value = "Passwords do not match!";
    successMessage.value = "";
    return;
  }

  if (!validatePassword()) return;

  // Split full name into first and last names
  const [fname, ...rest] = name.value.trim().split(" ");
  const lname = rest.join(" ") || "";

  try {
    const response = await api.post("/register", {
      fname,
      lname,
      email: email.value,
      password: password.value,
    });

    if (response.data.status === "ok") {
      successMessage.value = "Registration successful! Redirecting to login...";
      errorMessage.value = "";

      setTimeout(() => {
        router.push("/login");
      }, 2000);
    } else {
      errorMessage.value = response.data.message || "Registration failed.";
      successMessage.value = "";
    }
  } catch (err) {
    console.error(err);
    errorMessage.value =
        err.response?.data?.message || "Server error. Please try again.";
    successMessage.value = "";
  }
};
</script>

<style scoped>
.register-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 90vh;
  background: url("../images/BG.jpg");
  padding: 1rem;
}

.register-card {
  display: flex;
  background: #fff9e0;
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
.password-hint {
  font-size: 0.75rem;
  color: #555;
  margin-top: -8px;
  margin-bottom: -2px;
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

.success-msg {
  color: #2e7d32;
  font-weight: bold;
  margin-top: 10px;
  text-align: center;
}

.error-msg {
  color: #c62828;
  font-weight: bold;
  margin-top: 10px;
  text-align: center;
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



