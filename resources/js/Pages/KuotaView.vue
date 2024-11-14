<template>
    <section class="container mx-auto p-8">
      <h1 class="text-2xl font-semibold mb-6">Jumlah Pendaki per Tanggal</h1>
  
      <!-- Input untuk memilih tanggal -->
      <div class="mb-6">
        <label for="tanggal" class="block text-gray-700 font-semibold">Pilih Tanggal</label>
        <input
          type="date"
          id="tanggal"
          v-model="selectedDate"
          class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
          @change="fetchKuota"
        />
      </div>
  
      <!-- Menampilkan hasil kuota pada tanggal yang dipilih -->
      <div v-if="kuota !== null" class="bg-white p-6 rounded-lg shadow-md">
        <p class="text-lg font-medium text-gray-800">Jumlah Pendaki pada {{ selectedDate }}: 
          <span class="text-blue-600">{{ kuota }}</span>
        </p>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    name: 'KuotaView',
    data() {
      return {
        selectedDate: '', // Menyimpan tanggal yang dipilih
        kuota: null, // Menyimpan jumlah pendaki untuk tanggal yang dipilih
      };
    },
    methods: {
      // Fungsi untuk mengambil data kuota berdasarkan tanggal yang dipilih
      async fetchKuota() {
        if (!this.selectedDate) return; // Pastikan tanggal dipilih
  
        try {
          const response = await fetch(`/api/kuota/${this.selectedDate}`);
          const data = await response.json();
          this.kuota = data.kuota;
        } catch (error) {
          console.error("Terjadi kesalahan:", error);
          alert("Gagal mengambil data kuota.");
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 900px;
  }
  
  .bg-white {
    background-color: #ffffff;
  }
  
  .text-blue-600 {
    color: #3b82f6;
  }
  </style>
  