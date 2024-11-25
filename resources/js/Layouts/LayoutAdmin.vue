<template>
  <header class="flex flex-wrap gap-5 justify-between items-center px-20 py-4 w-full bg-gray-900 text-white max-md:px-5 max-md:max-w-full">
    <!-- Logo -->
    <div class="flex gap-1 items-center text-lg tracking-wide text-white">
      <img loading="lazy" src="/images/icon.png" class="object-contain w-10 h-10" alt="Mendasky logo" />
      <h1 class="text-xl font-semibold">
        MENDASKY - <span class="font-bold">Admin</span>
      </h1>
    </div>
    
    <!-- Navbar -->
    <nav class="flex flex-wrap gap-8 items-center text-base tracking-wide whitespace-nowrap text-gray-300">
      <a href="/menunggu-konfirmasi" class="hover:underline hover:text-white">Menunggu Konfirmasi</a>
      <a href="/terkonfirmasi" class="hover:underline hover:text-white">Terkonfirmasi</a>
    </nav>

    <!-- Logout Button -->
    <div class="flex gap-2.5 text-base tracking-wide leading-none whitespace-nowrap">
      <button @click="logout" class="gap-2.5 px-5 py-3 text-white bg-red-700 rounded-md min-h-[44px] hover:bg-red-600">
        Logout
      </button>
    </div>
  </header>
</template>

<script>
import { useRouter } from 'vue-router';
import { Inertia } from '@inertiajs/inertia';

export default {
  setup() {
    const router = useRouter();

    const logout = async () => {
      await Inertia.post(route('logout'), {}, {
        onSuccess: () => {
          router.push('/');
        }
      });
    };

    return {
      logout,
    };
  },
};
</script>

<style scoped>
.bg-gray-900 {
  background-color: #1a202c;
}

.text-white {
  color: #fff;
}

.text-gray-300 {
  color: #d1d5db;
}

.hover\:underline:hover {
  text-decoration: underline;
}

.hover\:text-white:hover {
  color: #ffffff;
}

.bg-red-700 {
  background-color: #c53030;
}

.hover\:bg-red-600:hover {
  background-color: #9b2c2c;
}
</style>
