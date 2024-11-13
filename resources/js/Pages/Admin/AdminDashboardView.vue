<template>
    <div class="container mx-auto p-8">
      <h1 class="text-2xl font-semibold mb-6">Admin Dashboard - Reservations</h1>
  
      <table class="w-full border border-gray-300 border-collapse">
        <thead>
          <tr class="bg-gray-200">
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">NIK</th>
            <th class="px-4 py-2 border">Phone</th>
            <th class="px-4 py-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="reservasi in reservasis" :key="reservasi.id">
            <td class="px-4 py-2 border">{{ reservasi.id }}</td>
            <td class="px-4 py-2 border">{{ reservasi.nama_ketua }}</td>
            <td class="px-4 py-2 border">{{ reservasi.nik_ketua }}</td>
            <td class="px-4 py-2 border">{{ reservasi.telepon_ketua }}</td>
            <td class="px-4 py-2 border flex gap-2">
              <button @click="editReservation(reservasi.id)" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</button>
              <button @click="deleteReservation(reservasi.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
  import { ref, onMounted } from 'vue';
  
  export default {
    name: 'AdminDashboardView',
    setup() {
      const reservasis = ref([]);
  
      const fetchReservations = async () => {
        try {
          const response = await fetch('/admin/reservations'); // Fetch reservations from backend
          reservasis.value = await response.json();
        } catch (error) {
          console.error("Error fetching reservations:", error);
        }
      };
  
      const editReservation = (id) => {
        Inertia.get(`/admin/reservations/${id}/edit`);
      };
  
      const deleteReservation = async (id) => {
        if (confirm("Are you sure you want to delete this reservation?")) {
          Inertia.delete(`/admin/reservations/${id}`);
        }
      };
  
      onMounted(fetchReservations);
  
      return {
        reservasis,
        editReservation,
        deleteReservation,
      };
    },
  };
  </script>  