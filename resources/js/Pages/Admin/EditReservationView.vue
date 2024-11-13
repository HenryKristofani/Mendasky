<template>
    <div class="container mx-auto p-8">
      <h1 class="text-2xl font-semibold mb-6">Edit Reservation</h1>
  
      <form @submit.prevent="updateReservation">
        <div class="mb-4">
          <label for="nama_ketua" class="block text-sm font-semibold">Name</label>
          <input type="text" id="nama_ketua" v-model="form.nama_ketua" class="mt-1 p-2 border rounded w-full">
        </div>
        <!-- Add other form fields similar to 'Name' for 'NIK', 'Phone', etc. -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
      </form>
    </div>
  </template>
  
  <script>
  import { ref, reactive } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  
  export default {
    props: ['reservasi'],
    setup(props) {
      const form = reactive({ ...props.reservasi });
  
      const updateReservation = () => {
        Inertia.put(`/admin/reservations/${form.id}`, form);
      };
  
      return {
        form,
        updateReservation,
      };
    },
  };
  </script>
  