<template>
  <header class="flex flex-wrap gap-5 justify-between items-start px-20 pt-5 pb-1.5 w-full bg-white max-md:px-5 max-md:max-w-full">
      <div class="flex gap-1 items-center text-lg tracking-wide text-gray-900">
          <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/8723beb3ce8a3da5b8a6b0df8891892d9e68364259706b21029f7e5f4dc40e5f?placeholderIfAbsent=true&apiKey=7a94906f21da4dddb192bb8dc0012a21" class="object-contain shrink-0 self-stretch my-auto aspect-[1.05] w-[41px]" alt="Mendasky logo" />
          <h1 class="self-stretch my-auto">
              MENDA<span class="font-bold">SKY</span>
          </h1>
      </div>
      <nav class="flex flex-wrap gap-10 items-start mt-3.5 text-base tracking-wide whitespace-nowrap text-zinc-800">
          <a href="#" class="hover:underline">Beranda</a>
          <a href="/reservasi" class="hover:underline">Reservasi</a>
          <a href="#" class="hover:underline">Berita</a>
          <a href="#" class="hover:underline">Panduan</a>
          <a href="#" class="hover:underline">Kontak</a>
      </nav>
      <div class="flex gap-2.5 text-base tracking-wide leading-none whitespace-nowrap">
          <!-- Tombol Register dengan event click -->
          <button @click="goToRegister" class="gap-2.5 self-stretch px-5 py-3 text-cyan-700 bg-white rounded-md border border-cyan-700 border-solid min-h-[44px]">
              Register
          </button>
          <button @click="goToLogin" class="gap-2.5 self-stretch px-5 py-3 text-white bg-cyan-700 rounded-md min-h-[44px]">
              Login
          </button>
      </div>
  </header>
</template>

<script>
export default {
  name: 'Header',
  methods: {
      goToLogin() {
          window.location.href = '/login';
      },
      goToRegister() {
          window.location.href = '/register';
      }
  }
}
</script>
