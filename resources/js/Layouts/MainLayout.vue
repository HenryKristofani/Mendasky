<template>
<<<<<<< Updated upstream
    <HeaderView />
    <main>
      <slot></slot>
    </main>
    <FooterView />
  </template>
  
  <script setup>
  import HeaderView from './HeaderView.vue';
  import FooterView from './FooterView.vue';
  </script>
  
=======
  <div>
      <!-- Header -->
      <header class="bg-gray-800 text-white py-4">
          <nav class="container mx-auto flex justify-between items-center px-4">
              <div class="text-2xl font-bold">MENDASKY</div>
              <ul class="flex space-x-6 text-lg">
                  <li><a href="#" class="hover:underline">Beranda</a></li>
                  <li><a href="#" class="hover:underline">Reservasi</a></li>
                  <li><a href="#" class="hover:underline">Event</a></li>
                  <li><a href="#" class="hover:underline">Poin</a></li>
                  <li><a href="#" class="hover:underline">Kontak</a></li>
              </ul>
              <div class="flex space-x-4">
                  <button class="px-4 py-2 bg-blue-500 rounded-lg hover:bg-blue-600">Register</button>
                  <router-link to="/login">
                  <button class="px-4 py-2 bg-blue-700 rounded-lg hover:bg-blue-800">Login</button>
                </router-link>
                </div>
          </nav>
      </header>

      <!-- Content -->
      <main class="container mx-auto p-6">
          <slot/>
      </main>

      <!-- Footer -->
      <footer class="bg-gray-800 text-white py-4 text-center">
          <p>&copy; 2024 MENDASKY | Semua hak cipta dilindungi.</p>
      </footer>
  </div>
</template>
>>>>>>> Stashed changes
