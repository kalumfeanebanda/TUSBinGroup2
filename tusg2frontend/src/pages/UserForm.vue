<template>
  <div class="page">
    <section class="user-form-section">
      <h2>{{ isEdit ? 'Update User' : 'Create New User' }}</h2>

      <form @submit.prevent="saveUser">
        <div class="form-group">
          <label>First Name</label>
          <input v-model="form.firstName" type="text" required />
        </div>

        <div class="form-group">
          <label>Last Name</label>
          <input v-model="form.lastName" type="text" required />
        </div>

        <div class="form-group">
          <label>Email</label>
          <input v-model="form.email" type="email" required />
        </div>

        <div class="form-group" v-if="!isEdit">
          <label>Password</label>
          <input v-model="form.password" type="password" required />
        </div>

        <div class="form-actions">
          <button type="submit" class="btn save">{{ isEdit ? 'Update' : 'Create' }}</button>
          <button type="button" class="btn cancel" @click="goBack">Cancel</button>
        </div>
      </form>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { createUser, updateUser, getUserById } from '@/services/user.js'

const route = useRoute()
const router = useRouter()

const isEdit = ref(false)
const form = ref({
  firstName: '',
  lastName: '',
  email: '',
  password: ''
})

// If there's an ID in the URL, we’re in edit mode
onMounted(async () => {
  if (route.params.id) {
    isEdit.value = true
    const user = await getUserById(route.params.id)
    form.value = {
      firstName: user.fname,
      lastName: user.lname,
      email: user.email,
      password: ''
    }
  }
})

const validatePassword = () => {
  const regex =
      /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

  return regex.test(form.value.password);
};





// Save (create or update)
async function saveUser() {
  if (!isEdit.value && !validatePassword()) {
    alert("Password must be 8+ characters, include 1 uppercase letter, 1 number & 1 special character.");
    return;
  }




  try {
    // Map frontend fields to backend fields
    const payload = {
      fname: form.value.firstName,
      lname: form.value.lastName,
      email: form.value.email,
      password: form.value.password
    }

    if (isEdit.value) {
      await updateUser(route.params.id, payload)
      alert('User updated!')
    } else {
      await createUser(payload)
      alert('User created!')
    }

    router.push('/users')
  } catch (err) {
    alert(err?.response?.data?.message ?? 'Save failed')
  }
}

function goBack() {
  router.push('/users')
}
</script>

<style scoped>

.page{
  background: url("../images/BG.jpg");
  min-height: 60vh;

  padding: 1rem;
}
.user-form-section {
  background: #fff9e0;
  padding: 1.5rem;
  max-width: 600px;
  margin: 2rem auto;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 1rem;
  display: flex;
  flex-direction: column;
}

label {
  font-weight: 600;
  margin-bottom: 0.4rem;
}

input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  margin-top: 1.5rem;
}

.btn {
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.5rem 1rem;
  font-weight: 600;
  cursor: pointer;
}

.btn.save {
  background-color: #4b8b3b;
}

.btn.cancel {
  background-color: #d9534f;
}
</style>