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
              v-if="user.status === 'aktif'"
              @click="blockUser(user.id)"
            >
              Block
            </button>
            <button
              v-if="user.status === 'blokir'"
              @click="unblockUser(user.id)"
            >
              Unblock
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
          const response = await fetch(`/api/users/${userId}/block`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
            },
          });

          if (response.ok) {
            const data = await response.json();
            alert(data.message);
            this.fetchUsers();
          } else {
            alert('Failed to block user.');
          }
        } catch (error) {
          console.error('Error blocking user:', error);
        }
      }
    },
    async unblockUser(userId) {
  if (confirm('Are you sure you want to unblock this user?')) {
    try {
      // Ambil CSRF token dari meta tag
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      const response = await fetch(`/api/users/${userId}/unblock`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken, // Sertakan CSRF token
        },
      });

      if (response.ok) {
        const data = await response.json();
        alert(data.message);
        this.fetchUsers();
      } else {
        alert('Failed to unblock user.');
      }
    } catch (error) {
      console.error('Error unblocking user:', error);
    }
  }
}
,
  },
};
</script>
