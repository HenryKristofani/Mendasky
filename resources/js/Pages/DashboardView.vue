<template>
    <div>
        <header class="flex justify-between items-center p-4 bg-gray-800 text-white">
            <h1>Admin Dashboard</h1>
            <button @click="logout" class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded">
                Logout
            </button>
        </header>
        
        <table class="min-w-full bg-white mt-4 border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">ID Booking</th>
                    <th class="py-2 px-4 border-b">Nama Ketua</th>
                    <th class="py-2 px-4 border-b">NIK Ketua</th>
                    <th class="py-2 px-4 border-b">Telepon Ketua</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="reservasi in reservasis" :key="reservasi.id">
                    <td class="py-2 px-4 border-b">{{ reservasi.id }}</td>
                    <td class="py-2 px-4 border-b">{{ reservasi.nama_ketua }}</td>
                    <td class="py-2 px-4 border-b">{{ reservasi.nik_ketua }}</td>
                    <td class="py-2 px-4 border-b">{{ reservasi.telepon_ketua }}</td>
                    <td class="py-2 px-4 border-b">
                        <button @click="editReservation(reservasi.id)" class="bg-blue-500 hover:bg-blue-400 text-white px-2 py-1 rounded">Edit</button>
                        <button @click="deleteReservation(reservasi.id)" class="bg-red-500 hover:bg-red-400 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        reservasis: Array
    },
    methods: {
        editReservation(id) {
            Inertia.visit(`/admin/reservations/${id}/edit`);
        },
        deleteReservation(id) {
            Inertia.delete(`/admin/reservations/${id}`, {
                onSuccess: () => {
                    this.$emit('reservationDeleted');
                }
            });
        },
        logout() {
            Inertia.post('/logout', {}, {
                onSuccess: () => {
                    Inertia.visit('/login');
                }
            });
        }
    }
}
</script>

<style scoped>
/* Styling for the table and layout */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 0.75rem;
    text-align: left;
    border: 1px solid #e5e7eb;
}

th {
    background-color: #f3f4f6;
}
</style>
