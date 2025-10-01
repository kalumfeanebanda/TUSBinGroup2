<template>
  <div class="bg-pink-50 flex items-center justify-center min-h-screen">
    <div
        class="bg-white shadow-lg rounded-lg flex flex-col md:flex-row overflow-hidden w-[800px] max-w-full"
    >
      <!-- Left: Form -->
      <div class="w-full md:w-1/2 p-8">
        <h3 class="text-gray-400 font-semibold">SignUp</h3>
        <h1 class="text-2xl font-bold mt-2">Get Started Now!</h1>

        <!-- Form -->
        <form @submit.prevent="handleSubmit" class="mt-6 space-y-4">
          <input
              v-model="form.name"
              type="text"
              placeholder="Name"
              required
              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
          />
          <input
              v-model="form.email"
              type="email"
              placeholder="Email"
              required
              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
          />
          <input
              v-model="form.password"
              type="password"
              placeholder="Password"
              required
              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
          />
          <input
              v-model="form.retypePassword"
              type="password"
              placeholder="Retype Password"
              required
              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"
          />

          <p v-if="error" class="text-red-500 text-sm">{{ error }}</p>

          <button
              type="submit"
              class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
          >
            Sign Up
          </button>
        </form>

        <!-- Bottom Link -->
        <p class="text-sm text-gray-500 mt-4">
          Have An Account?
          <router-link to="/login" class="font-semibold text-gray-800 hover:underline">
            Log In
          </router-link>
        </p>
      </div>

      <!-- Right: Illustration -->
      <div
          class="w-full md:w-1/2 bg-blue-100 flex items-center justify-center p-6"
      >
        <img src="@/assets/recycle.jpg" alt="Recycle Illustration" class="w-64 h-64 object-contain"/>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const form = ref({
  name: "",
  email: "",
  password: "",
  retypePassword: "",
});

const error = ref("");

const handleSubmit = () => {

  if (form.value.password !== form.value.retypePassword) {
    error.value = "Passwords do not match!";
    return;
  }

  error.value = "";


  console.log("Submitting form:", form.value);
  alert("Sign Up Successful!");
};
</script>
