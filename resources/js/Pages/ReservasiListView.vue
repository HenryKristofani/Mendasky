<template>
    <HeaderLogView></HeaderLogView>
    <section class="container mx-auto p-8">
        <h1 class="text-2xl font-semibold mb-6">Daftar Reservasi Pendakian</h1>

        <table class="w-full border border-gray-300 border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border-gray-300">ID Booking</th>
                    <th class="px-4 py-2 border-gray-300">Nama Ketua</th>
                    <th class="px-4 py-2 border-gray-300">NIK Ketua</th>
                    <th class="px-4 py-2 border-gray-300">Telepon Ketua</th>
                    <th class="px-4 py-2 border-gray-300">Tanggal Reservasi</th>
                    <th class="px-4 py-2 border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="reservasi in reservasis" :key="reservasi.id">
                    <td class="px-4 py-2 border-t border-gray-300">{{ reservasi.id }}</td>
                    <td class="px-4 py-2 border-t border-gray-300">{{ reservasi.nama_ketua }}</td>
                    <td class="px-4 py-2 border-t border-gray-300">{{ reservasi.nik_ketua }}</td>
                    <td class="px-4 py-2 border-t border-gray-300">{{ reservasi.telepon_ketua }}</td>
                    <td class="px-4 py-2 border-t border-gray-300">{{ formatTanggal(reservasi.tanggal_reservasi) }}</td>
                    <td class="px-4 py-2 border-t border-gray-300 flex space-x-2">
                        <button @click="showDetails(reservasi.id)" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Detail</button>
                        <button @click="goToPembayaran(reservasi.id)" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Bayar</button>
                        <button @click="deleteReservasi(reservasi.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Pembatalan</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal untuk menampilkan detail reservasi -->
        <div v-if="selectedReservasi" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg max-w-lg w-full">
                <h2 class="text-xl font-semibold mb-4">Detail Reservasi</h2>
                <p><strong>ID Booking:</strong> {{ selectedReservasi.id }}</p>
                <p><strong>Nama Ketua:</strong> {{ selectedReservasi.nama_ketua }}</p>
                <p><strong>NIK Ketua:</strong> {{ selectedReservasi.nik_ketua }}</p>
                <p><strong>Telepon Ketua:</strong> {{ selectedReservasi.telepon_ketua }}</p>
                <p><strong>Alamat Ketua:</strong> {{ selectedReservasi.alamat_ketua }}</p>
                <p><strong>Tanggal Reservasi:</strong> {{ formatTanggal(selectedReservasi.tanggal_reservasi) }}</p>
                
                <h3 class="mt-4 font-semibold">Anggota Kelompok:</h3>
                <ul v-if="selectedReservasi.anggota && selectedReservasi.anggota.length">
                    <li v-for="(member, index) in selectedReservasi.anggota" :key="index" class="mb-2">
                        <p><strong>Nama Anggota {{ index + 1 }}:</strong> {{ member.nama }}</p>
                        <p><strong>NIK Anggota {{ index + 1 }}:</strong> {{ member.nik }}</p>
                    </li>
                </ul>
                <p v-else>Tidak ada anggota tambahan.</p>
                
                <button @click="closeDetails" class="mt-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Tutup</button>
            </div>
        </div>
    </section>
</template>

<script>
import { ref, onMounted } from 'vue';
import HeaderLogView from '@/Layouts/HeaderLogView.vue';

export default {
    components: {
        HeaderLogView
    },
    name: "ReservasiListView",
    setup() {
        const reservasis = ref([]);
        const selectedReservasi = ref(null);

        // Fetch data reservasi dari server saat komponen dimuat
        const fetchReservasis = async () => {
            try {
                const response = await fetch('/reservasis');
                if (!response.ok) throw new Error("Gagal mengambil data");
                reservasis.value = await response.json();
            } catch (error) {
                console.error(error);
                alert("Terjadi kesalahan saat mengambil data reservasi.");
            }
        };
        onMounted(fetchReservasis);

        // Fungsi untuk menampilkan detail reservasi
        const showDetails = async (id) => {
            try {
                const response = await fetch(`/reservasi/${id}`);
                if (!response.ok) throw new Error("Gagal mengambil detail data");
                selectedReservasi.value = await response.json();
            } catch (error) {
                console.error(error);
                alert("Terjadi kesalahan saat mengambil detail reservasi.");
            }
        };

        // Fungsi untuk menutup detail
        const closeDetails = () => {
            selectedReservasi.value = null;
        };

        // Fungsi untuk memformat tanggal
        const formatTanggal = (tanggal) => {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(tanggal).toLocaleDateString('id-ID', options);
        };

        return { reservasis, selectedReservasi, showDetails, closeDetails, formatTanggal };
    }
};
</script>

<style scoped>
.container {
    max-width: 900px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border: 1px solid #D1D5DB;
}

th {
    background-color: #E5E7EB;
}

.modal-background {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 100%;
    max-width: 500px;
}
</style>
