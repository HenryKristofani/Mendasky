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
      <a href="/reservasi" class="hover:underline">Reservasi</a>
      <a href="#" class="hover:underline">Berita</a>
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
import { onMounted, ref } from 'vue'; // Import required Vue functions
import { useRouter } from 'vue-router'; // Import useRouter from vue-router

export default {
  setup() {
      const router = useRouter(); // Get the router instance

      // Store CSRF token in local storage on component mount
      onMounted(() => {
          const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
          localStorage.setItem("csrf_token", csrfToken);
      });

      const logout = async () => {
          try {
              const token = localStorage.getItem("authToken");
              const csrfToken = localStorage.getItem("csrf_token"); // Retrieve CSRF token from local storage
              const response = await fetch("http://127.0.0.1:8000/logout", {
                  method: "POST",
                  headers: {
                      Authorization: `Bearer ${token}`,
                      Accept: "application/json",
                      "Content-Type": "application/json",
                      "X-CSRF-TOKEN": csrfToken, // Include CSRF token from local storage
                  },
                  credentials: "include",
              });

              if (!response.ok) {
                  throw new Error("Logout failed");
              }

              // Clear tokens from local storage
              localStorage.removeItem("authToken");
              localStorage.removeItem("csrf_token"); // Clear CSRF token

              // Redirect to the home page
              router.push("/"); // Use Vue Router to redirect
          } catch (error) {
              console.error("Logout error:", error);
              // Handle error as needed (e.g., show a notification)
          }
      };

      return { logout }; // Return the logout function for template usage
  },
};
</script>
