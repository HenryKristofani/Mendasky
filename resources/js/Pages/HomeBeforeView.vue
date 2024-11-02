<template>
  <MainLayout>
      <!-- Hero Section -->
      <HeroSection />

      <!-- Alert Section -->
      <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 my-6 rounded-lg">
          <p class="font-semibold">Cek ketersediaan kondisi terbaru untuk melakukan pendakian. <a href="#" class="underline">Pelajari Selengkapnya</a></p>
      </div>
      
      <!-- Content Sections (Trail Map, Kondisi Cuaca, Berita, dll.) -->
      <div class="mt-8">
          <Detail />
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
          <Peringatan title="Kondisi Terkini Cuaca" />
          <Peringatan title="Cek Kuota Pendakian" />
      </div>
      <Berita />
      <InstallApp />
  </MainLayout>
</template>

<script>
import MainLayout from '../Layouts/MainLayout.vue';
import HeroSection from './HomeComponents/Hero.vue';
import Detail from './HomeComponents/Detail.vue';
import Peringatan from './HomeComponents/Peringatan.vue';
import Berita from './HomeComponents/Berita.vue';
import InstallApp from './HomeComponents/InstallApp.vue'

export default {
  components: {
      MainLayout,
      HeroSection,
      Detail,
      Peringatan,
      Berita,
      InstallApp
  }
};
</script>
