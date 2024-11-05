<template>
    <section class="flex flex-col tracking-wide rounded-none">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                Formulir Reservasi Mendaki
            </h2>
            <form
                action="/submit-reservasi"
                method="POST"
                enctype="multipart/form-data"
            >
                <!-- Form Ketua Kelompok -->
                <!-- Nama Ketua Kelompok -->
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-semibold">Nama Ketua Kelompok</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama_ketua"
                        class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                        placeholder="Masukkan nama ketua kelompok"
                        required
                    />
                </div>

                <!-- NIK Ketua Kelompok -->
                <div class="mb-4">
                    <label for="nik" class="block text-gray-700 font-semibold">NIK Ketua Kelompok</label>
                    <input
                        type="text"
                        id="nik"
                        name="nik_ketua"
                        class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                        placeholder="Masukkan NIK ketua kelompok"
                        required
                    />
                </div>

                <!-- Upload Gambar KTP Ketua Kelompok -->
                <div class="mb-4">
                    <label for="ktp" class="block text-gray-700 font-semibold">Upload Gambar KTP Ketua Kelompok</label>
                    <input
                        type="file"
                        id="ktp"
                        name="ktp_ketua"
                        class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                        accept="image/*"
                        required
                    />
                </div>

                <!-- Nomor Telepon Ketua Kelompok -->
                <div class="mb-4">
                    <label for="telepon" class="block text-gray-700 font-semibold">Nomor Telepon Ketua Kelompok</label>
                    <input
                        type="tel"
                        id="telepon"
                        name="telepon_ketua"
                        class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                        placeholder="Masukkan nomor telepon ketua kelompok"
                        required
                    />
                </div>

                <!-- Alamat Ketua Kelompok -->
                <div class="mb-6">
                    <label for="alamat" class="block text-gray-700 font-semibold">Alamat</label>
                    <textarea
                        id="alamat"
                        name="alamat_ketua"
                        rows="4"
                        class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                        placeholder="Masukkan alamat ketua kelompok"
                        required
                    ></textarea>
                </div>

                <!-- Form Anggota Kelompok -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Anggota Kelompok</h3>

                    <div v-for="(member, index) in anggota" :key="index" class="mb-4 border border-gray-300 rounded-md p-4">
                        <label :for="'nama_anggota_' + index" class="block text-gray-700 font-semibold">Nama Anggota</label>
                        <input
                            type="text"
                            :id="'nama_anggota_' + index"
                            v-model="member.nama"
                            :name="'nama_anggota_' + index"
                            class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                            placeholder="Masukkan nama anggota"
                            required
                        />

                        <label :for="'nik_anggota_' + index" class="block text-gray-700 font-semibold mt-4">NIK Anggota</label>
                        <input
                            type="text"
                            :id="'nik_anggota_' + index"
                            v-model="member.nik"
                            :name="'nik_anggota_' + index"
                            class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                            placeholder="Masukkan NIK anggota"
                            required
                        />

                        <button type="button" @click="removeMember(index)" class="text-red-600 mt-2">Hapus Anggota</button>
                    </div>

                    <!-- Tombol Tambah Anggota, hanya muncul jika anggota kurang dari 4 -->
                    <button
                        type="button"
                        @click="addMember"
                        class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-green-600 transition duration-200"
                        v-if="anggota.length < 4"
                    >
                        Tambah Anggota
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200"
                    >
                        Submit Reservasi
                    </button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
export default {
    name: "ReservationOnline",
    data() {
        return {
            anggota: [
                { nama: "", nik: "" } // Data awal untuk satu anggota
            ]
        };
    },
    methods: {
        addMember() {
            // Hanya tambahkan anggota jika jumlah anggota kurang dari 4
            if (this.anggota.length < 4) {
                this.anggota.push({ nama: "", nik: "" });
            }
        },
        removeMember(index) {
            this.anggota.splice(index, 1); // Menghapus anggota berdasarkan index
        }
    }
};
</script>
