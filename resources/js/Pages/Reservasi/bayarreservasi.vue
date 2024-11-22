<template>
  <div class="max-w-4xl mx-auto p-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
      <!-- Header Section -->
      <h1 class="text-3xl font-semibold text-gray-800 mb-6">Total Jumlah Anggota</h1>

      <!-- Loading State -->
      <div v-if="isLoading" class="text-center py-8">
        <p class="text-gray-600">Memuat data anggota...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <p>{{ error }}</p>
      </div>

      <!-- Content Section -->
      <div v-else class="space-y-6">
        <!-- Informasi Reservasi -->
        <div class="border-b pb-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Anggota</h2>
          <div class="grid grid-cols-1 gap-4">
            <div>
              <p class="text-gray-600">Total Anggota</p>
              <p class="font-medium">{{ totalAnggota }} orang</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  name: 'BayarReservasiView',
  setup() {
    const reservasi = ref({});
    const isLoading = ref(true);
    const error = ref(null);
    const totalAnggota = ref(0);

    const getReservasiId = () => {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('id');
    };

    const fetchReservasi = async () => {
      const id = getReservasiId();
      if (!id) {
        error.value = 'ID Reservasi tidak ditemukan';
        isLoading.value = false;
        return;
      }

      try {
        const response = await fetch(`/reservasi/${id}`);
        if (!response.ok) throw new Error('Gagal mengambil data reservasi');
        
        const data = await response.json();
        reservasi.value = data;
        // Hitung total anggota (ketua + anggota)
        totalAnggota.value = (data.anggota?.length || 0) + 1; // +1 untuk ketua
        
      } catch (err) {
        error.value = 'Terjadi kesalahan saat mengambil data reservasi';
        console.error(err);
      } finally {
        isLoading.value = false;
      }
    };

    onMounted(fetchReservasi);

    return {
      reservasi,
      isLoading,
      error,
      totalAnggota
    };
  }
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
}

.shadow-lg {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
