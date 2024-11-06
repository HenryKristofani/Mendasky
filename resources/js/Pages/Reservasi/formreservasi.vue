<template>
    <section class="flex flex-col tracking-wide rounded-none">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                Formulir Reservasi Mendaki
            </h2>
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
                <!-- Form Ketua Kelompok -->
                <!-- Nama Ketua Kelompok -->
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-semibold">Nama Ketua Kelompok</label>
                    <input
                        type="text"
                        id="nama"
                        v-model="nama_ketua"
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
                        v-model="nik_ketua"
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
                        @change="handleFileUpload"
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
                        v-model="telepon_ketua"
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
                        v-model="alamat_ketua"
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
            anggota: [{ nama: "", nik: "" }],
            nama_ketua: "",
            nik_ketua: "",
            ktp_ketua: null,
            telepon_ketua: "",
            alamat_ketua: "",
        };
    },
    mounted() {
        // Ambil CSRF token dari meta tag dan simpan di localStorage
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        localStorage.setItem('csrf_token', csrfToken);
    },
    methods: {
        addMember() {
            if (this.anggota.length < 4) {
                this.anggota.push({ nama: "", nik: "" });
            }
        },
        removeMember(index) {
            this.anggota.splice(index, 1);
        },
        handleFileUpload(event) {
            this.ktp_ketua = event.target.files[0];
        },
        async submitForm() {
    // Validate that at least one member is present
    if (this.anggota.length === 0) {
        alert("Harap tambahkan setidaknya satu anggota.");
        return;
    }

    // Create FormData to send with file
    let formData = new FormData();
    formData.append('nama_ketua', this.nama_ketua);
    formData.append('nik_ketua', this.nik_ketua);
    formData.append('ktp_ketua', this.ktp_ketua);
    formData.append('telepon_ketua', this.telepon_ketua);
    formData.append('alamat_ketua', this.alamat_ketua);

    // Add each member to FormData as an array
    this.anggota.forEach((member, index) => {
        formData.append(`anggota[${index}][nama]`, member.nama);
        formData.append(`anggota[${index}][nik]`, member.nik);
    });

    // Log form data to the console for debugging
    console.log(Array.from(formData)); // Check the structure of formData

    // Get CSRF token from localStorage
    const csrfToken = localStorage.getItem('csrf_token');

    try {
        const response = await fetch('/submit-reservasi', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken, // Include CSRF token in headers
                'X-Requested-With': 'XMLHttpRequest', // Indicate AJAX request
            },
        });

        if (response.ok) {
            const data = await response.json();
            alert(data.message);

            // Redirect to /reservasilist after successful submission
            window.location.href = '/reservasilist';
        } else {
            const errorData = await response.json();
            console.error('Error:', errorData);
            alert('Terjadi kesalahan saat menyimpan data: ' + errorData.message);
        }
    } catch (error) {
        console.error('Fetch error:', error);
        alert('Terjadi kesalahan saat menyimpan data.');
    }
}

    }
};
</script>
