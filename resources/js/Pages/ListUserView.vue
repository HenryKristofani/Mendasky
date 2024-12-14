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
                :disabled="user.status === 'blocked'" 
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
        users: []
      };
    },
    mounted() {
      this.fetchUsers();
    },
    methods: {
      fetchUsers() {
        fetch('/api/users')
          .then(response => response.json())
          .then(data => {
            this.users = data;
          })
          .catch(error => {
            console.error('Error fetching users:', error);
          });
      },
      blockUser(userId) {
        if (confirm('Are you sure you want to block this user?')) {
          fetch(`/api/users/${userId}/block`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
            },
          })
            .then(response => {
              if (response.ok) {
                alert('User blocked successfully.');
                this.fetchUsers(); // Refresh the user list
              } else {
                alert('Failed to block the user.');
              }
            })
            .catch(error => {
              console.error('Error blocking user:', error);
              alert('An error occurred while blocking the user.');
            });
        }
      }
    }
  };
  </script>
  
  <style>
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  thead {
    background-color: #f4f4f4;
  }
  
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  
  button {
    padding: 5px 10px;
    color: white;
    background-color: red;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }
  
  button:disabled {
    background-color: gray;
    cursor: not-allowed;
  }
  </style>
  