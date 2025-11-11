<script setup>
import { ref } from "vue";

const user = ref({
  name: "John Doe",
  email: "john@example.com",
  joined: "2025-01-12",
});

</script>

<template>
  <div class="profile-container">


    <div class="profile-header">
      <h1>Your Profile</h1>
      <p>Manage your account details and preferences</p>
    </div>


    <div class="profile-card">
      <h2>User Information</h2>

      <div class="info-row">
        <label>Name:</label>
        <span>{{ user.name }}</span>
      </div>

      <div class="info-row">
        <label>Email:</label>
        <span>{{ user.email }}</span>
      </div>

      <div class="info-row">
        <label>Joined:</label>
        <span>{{ user.joined }}</span>
      </div>

      <button class="btn update-btn">Update Profile</button>
    </div>
  </div>
</template>

<style scoped>

</style>
