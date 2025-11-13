<script setup>
import { ref, onMounted } from 'vue'
import { listUsers } from "@/services/user.js"
import { deleteUser} from "@/services/user.js";


const users = ref([])
const loading = ref(true)
const error = ref('')

// Load the user list
async function load() {
  loading.value = true; error.value = ''
  try { users.value = await listUsers() }
  catch { error.value = 'Could not load users.' }
  finally { loading.value = false }
}

// Delete a user
async function onDelete(id) {
  const yes = confirm('Delete this user?')
  if (!yes) return

  try {
    await deleteUser(id);
    await load()
  } catch (err) {
    alert(err?.response?.data?.message ?? 'Delete failed')
  }
}

// Fetch users when component mounts
onMounted(loadUsers)










</script>


  <template>
    <section class="users-section">
      <div class="users-header">
        <h2>Manage Users</h2>
        <button class="btn refresh" @click="load">Refresh</button>
      </div>

      <div v-if="loading" class="state">Loading…</div>
      <div v-else-if="error" class="state error">{{ error }}</div>
      <div v-else-if="users.length === 0" class="state">No users found.</div>

      <table v-else class="users-table">
        <thead>
        <tr>
          <th style="width: 80px">#</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th style="width: 220px">Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(user, index) in users" :key="user.id">
          <td class="muted">{{ index + 1 }}</td>
          <td>{{ user.firstName }}</td>
          <td>{{ user.lastName }}</td>
          <td>{{ user.email }}</td>
          <td class="actions">
            <button class="btn view">View</button>
            <button class="btn update">Update</button>
            <button class="btn delete" @click="onDelete(user.id)">Delete</button>
          </td>
        </tr>
        </tbody>
      </table>
    </section>
  </template>

  <script>
    export default {
      data() {
        return {
          users: [],
          loading: false,
          error: null
        };
      },
      methods: {
        async load() {
          this.loading = true;
          this.error = null;
          try {
// Replace with your API call
            const response = await fetch('/api/users');
            const data = await response.json();
            this.users = data;
          } catch (err) {
            this.error = 'Failed to load users';
          } finally {
            this.loading = false;
          }
        },
        onDelete(userId) {
// Add your delete logic here
          this.users = this.users.filter(u => u.id !== userId);
        }
      },
      mounted() {
        this.load();
      }
    };
  </script>

  <style scoped>
    /* Keep all styles exactly as your bin styles */
    :root {
      --green: #4b8b3b;
      --green-d: #3d7a31;
      --red: #d9534f;
      --blue: #0275d8;
      --muted: #6b7280;
      --border: #e0e0e0;
    }

    .users-section {
      background: #fff;
      padding: 1rem 1.5rem;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      margin: 2rem auto;
      max-width: 900px;
    }

    .users-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid var(--green);
      padding-bottom: 0.75rem;
      margin-bottom: 1rem;
    }

    .users-header h2 {
      margin: 0;
      color: #2f4f27;
      font-size: 1.4rem;
    }

    .btn {
      color: #fff;
      padding: 0.4rem 0.85rem;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 0.85rem;
      cursor: pointer;
      transition: none;
    }

    .btn.view {
      background-color: #0275d8;
    }

    .btn.update {
      background-color: #4b8b3b;
    }

    .btn.delete {
      background-color: #d9534f;
    }

    .users-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.95rem;
    }

    .users-table th,
    .users-table td {
      border: 1px solid var(--border);
      padding: 0.75rem 1rem;
      text-align: left;
    }

    .users-table th {
      background-color: #e7f3e5;
      font-weight: 700;
      color: #2f4f27;
    }

    .users-table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .actions {
      display: flex;
      gap: 0.5rem;
    }

    .muted {
      color: var(--muted);
    }

    .state {
      padding: 1rem;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 10px;
      text-align: center;
      color: #374151;
    }
    .state.error {
      border-color: #f0c2c2;
      color: #b91c1c;
    }
  </style>

