
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-md rounded-lg flex w-3/4 max-w-4xl">
      <div class="w-1/2 p-10">
        <h1 class="text-3xl font-bold mb-2">Welcome!</h1>
        <p class="text-gray-600 mb-6">Enter your Credentials to access your account</p>

        <form @submit.prevent="handleLogin">
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input
                v-model="email"
                type="email"
                placeholder="Enter your email"
                class="w-full border rounded px-3 py-2"
            />
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input
                v-model="password"
                type="password"
                placeholder="Enter your password"
                class="w-full border rounded px-3 py-2"
            />
          </div>

          <button
              type="submit"
              class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded"
          >
            Login
          </button>
        </form>

        <p class="mt-4 text-sm">
          Not Registered yet?
          <a href="/tusg2frontend/src/pages/Register" class="text-green-600 hover:underline">Register</a>
        </p>
      </div>

      <div class="w-1/2">
        <img
            src="@/assets/recycle.jpg"
            alt="Recycle"
            class="w-full h-full object-cover rounded-r-lg"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const email = ref('')
const password = ref('')

const handleLogin = () => {
  console.log('Email:', email.value)
  console.log('Password:', password.value)
}
</script>