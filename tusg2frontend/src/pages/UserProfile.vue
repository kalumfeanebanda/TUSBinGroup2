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
.profile-container {
  font-family: Arial, sans-serif;
  padding: 30px 20px;
  text-align: center;
}


.profile-header {
  background: #2c7a7b;
  color: white;
  padding: 40px 20px;
  border-radius: 10px;
  margin-bottom: 30px;
}

.profile-header h1 {
  font-size: 2rem;
  margin-bottom: 10px;
}


.profile-card {
  background: #f5f5f5;
  padding: 30px;
  max-width: 500px;
  margin: 0 auto;
  border-radius: 12px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}

.profile-card h2 {
  color: #2c7a7b;
  margin-bottom: 20px;
}


.info-row {
  display: flex;
  justify-content: space-between;
  padding: 10px 0;
  font-size: 1rem;
  border-bottom: 1px solid #ccc;
}

.info-row label {
  font-weight: bold;
  color: #333;
}


.btn {
  padding: 12px 25px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  color: white;
  margin-top: 20px;
  font-size: 16px;
}

.update-btn {
  background-color: #4caf50;
}

.update-btn:hover {
  background-color: #3d8c40;
}
</style>
