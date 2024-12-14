<template>
  <div>
    <h1>User List</h1>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.status }}</td>
          <td>{{ user.created_at }}</td>
          <td>{{ user.updated_at }}</td>
          <td>
            <button
              :disabled="user.status === 'blocked' || isLoading"
              @click="blockUser(user.id)"
            >
              {{ user.status === 'blocked' ? 'Blocked' : 'Block' }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      isLoading: false, // Tambahkan state loading
    };
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await fetch('/api/users');
        this.users = await response.json();
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    async blockUser(userId) {
  if (confirm('Are you sure you want to block this user?')) {
    try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token

      const response = await fetch(`/api/users/${userId}/block`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken, // Sertakan CSRF token di header
        },
      });

      if (response.ok) {
        const data = await response.json();
        alert(data.message); // Tampilkan pesan sukses
        this.fetchUsers(); // Refresh daftar pengguna
      } else if (response.status === 404) {
        alert('User not found.');
      } else {
        const errorData = await response.json();
        alert(`Error blocking user: ${errorData.message}`);
      }
    } catch (error) {
      console.error('Error:', error);
      alert('An unexpected error occurred.');
    }
  }
}
,
  },
};
</script>
