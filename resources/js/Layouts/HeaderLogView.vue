<template>
  <header class="flex flex-wrap gap-5 justify-between items-center px-20 py-4 w-full bg-gray-900 text-white max-md:px-5 max-md:max-w-full">
    <div class="flex gap-1 items-center text-lg tracking-wide text-white">
      <img loading="lazy" src="images/icon.png" class="object-contain w-10 h-10" alt="Mendasky logo" />
      <h1 class="text-xl font-semibold">
        MENDA<span class="font-bold">SKY</span>
      </h1>
    </div>
    <nav class="flex flex-wrap gap-8 items-center text-base tracking-wide whitespace-nowrap text-gray-300">
      <a href="/home" class="hover:underline hover:text-white">Beranda</a>
      
      <!-- Dropdown attached to Reservasi link -->
      <div 
        class="relative group"
        @mouseenter="showDropdown"
        @mouseleave="hideDropdown"
      >
        <a href="#" @click.prevent="toggleDropdown" class="hover:underline hover:text-white relative inline-block">Reservasi</a>
        <div
          v-if="dropdownOpen"
          class="absolute left-0 top-full bg-gray-800 shadow-lg rounded-md w-40 border border-gray-700 z-10"
        >
          <a href="/reservasi" class="block px-4 py-2 hover:bg-gray-700 text-gray-300 hover:text-white">Buat Reservasi</a>
          <a href="/reservasilist" class="block px-4 py-2 hover:bg-gray-700 text-gray-300 hover:text-white">Riwayat Reservasi</a>
        </div>
      </div>

      <a href="/berita" class="hover:underline hover:text-white">Berita</a>
      <a href="#" class="hover:underline hover:text-white">Panduan</a>
      <a href="#" class="hover:underline hover:text-white">Kontak</a>
    </nav>
    <div class="flex gap-2.5 text-base tracking-wide leading-none whitespace-nowrap">
      <button @click="logout" class="gap-2.5 px-5 py-3 text-white bg-red-700 rounded-md min-h-[44px] hover:bg-red-600">
        Logout
      </button>
    </div>
  </header>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Inertia } from '@inertiajs/inertia';

export default {
  setup() {
    const router = useRouter();
    const dropdownOpen = ref(false);

    const toggleDropdown = () => {
      dropdownOpen.value = !dropdownOpen.value;
    };

    const showDropdown = () => {
      dropdownOpen.value = true;
    };

    const hideDropdown = () => {
      dropdownOpen.value = false;
    };

    const logout = async () => {
      await Inertia.post(route('logout'), {}, {
        onSuccess: () => {
          router.push('/');
        }
      });
    };

    return {
      dropdownOpen,
      toggleDropdown,
      showDropdown,
      hideDropdown,
      logout,
    };
  },
};
</script>

<style scoped>
.relative {
  cursor: pointer;
}

.relative .absolute {
  top: 100%;
  left: 0;
  margin-top: 0;
}

.bg-gray-900 {
  background-color: #1a202c;
}

.text-white {
  color: #fff;
}

.text-gray-300 {
  color: #d1d5db;
}

.bg-gray-800 {
  background-color: #2d3748;
}

.border-gray-700 {
  border-color: #4a5568;
}

.hover\:bg-gray-700:hover {
  background-color: #4a5568;
}

.hover\:text-white:hover {
  color: #ffffff;
}
</style>
