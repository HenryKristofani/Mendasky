<template>
    <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <Hero />

        <!-- Alert Section -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-4">
            <p class="font-semibold">Cek ketersediaan kondisi terbaru untuk melakukan pendakian. <a href="#" class="underline">Pelajari Selengkapnya</a></p>
        </div>

        <!-- Trail Map Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Trail Map Mongkrang</h2>
            <Detail />
        </div>

        <!-- Kondisi dan Kuota Pendakian Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
            <Peringatan title="Kondisi Terkini Cuaca" />
            <Peringatan title="Cek Kuota Pendakian" />
        </div>

        <!-- Berita Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Berita Terkini</h2>
            <Berita />
        </div>

        <!-- Download App Section -->
        <InstallApp />

        <!-- Footer Section -->
        <footer class="mt-12 text-center">
            <p>&copy; 2024 Mendasky | Semua hak cipta dilindungi</p>
        </footer>
    </div>
</template>

<script>
import Hero from './HomeComponents/hero.vue';
import Detail from './HomeComponents/detail.vue';
import Peringatan from './HomeComponents/peringatan.vue';
import Berita from './HomeComponents/berita.vue';
import InstallApp from './HomeComponents/installapp.vue';

export default {
    components: {
        Hero,
        Detail,
        Peringatan,
        Berita,
        InstallApp,
    },
};
</script>

<style scoped>
/* Tambahkan style khusus jika diperlukan */
</style>
