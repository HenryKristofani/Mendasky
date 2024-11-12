<template>
  <header class="flex flex-wrap gap-5 justify-between items-start px-20 pt-5 pb-1.5 w-full bg-white max-md:px-5 max-md:max-w-full">
    <div class="flex gap-1 items-center text-lg tracking-wide text-gray-900">
      <img
        loading="lazy"
        src="https://cdn.builder.io/api/v1/image/assets/TEMP/8723beb3ce8a3da5b8a6b0df8891892d9e68364259706b21029f7e5f4dc40e5f?placeholderIfAbsent=true&apiKey=7a94906f21da4dddb192bb8dc0012a21"
        class="object-contain shrink-0 self-stretch my-auto aspect-[1.05] w-[41px]"
        alt="Mendasky logo"
      />
      <h1 class="self-stretch my-auto">
        MENDA<span class="font-bold">SKY</span>
      </h1>
    </div>
    <nav class="flex flex-wrap gap-10 items-start mt-3.5 text-base tracking-wide whitespace-nowrap text-zinc-800">
      <a href="/home" class="hover:underline">Beranda</a>

      <!-- Dropdown directly attached to Reservasi link -->
      <div 
        class="relative group"
        @mouseenter="showDropdown"
        @mouseleave="hideDropdown"
      >
        <a href="#" @click.prevent="toggleDropdown" class="hover:underline relative inline-block">Reservasi</a>
        <div
          v-if="dropdownOpen"
          class="absolute left-0 top-full bg-white shadow-lg rounded-md w-40 border border-gray-200 z-10"
        >
          <a href="/reservasi" class="block px-4 py-2 hover:bg-gray-100">Buat Reservasi</a>
          <a href="/reservasilist" class="block px-4 py-2 hover:bg-gray-100">Riwayat Reservasi</a>
        </div>
      </div>

      <a href="/berita" class="hover:underline">Berita</a>
      <a href="#" class="hover:underline">Panduan</a>
      <a href="#" class="hover:underline">Kontak</a>
    </nav>
    <div class="flex gap-2.5 text-base tracking-wide leading-none whitespace-nowrap">
      <button @click="logout" class="gap-2.5 self-stretch px-5 py-3 text-white bg-red-700 rounded-md min-h-[44px]">
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
  /* Position the dropdown directly below the link */
  top: 100%;
  left: 0;
  margin-top: 0; /* Remove any margin between the dropdown and the link */
}
</style>
