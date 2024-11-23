<template>
  <div>
    <h2>Upload Bukti Pembayaran</h2>
    <form @submit.prevent="uploadBuktiPembayaran">
      <input type="file" @change="handleFileUpload" />
      <button type="submit">Upload</button>
    </form>
    <p v-if="message" class="notification">{{ message }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      file: null,
      message: "",
    };
  },
  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    async uploadBuktiPembayaran() {
  if (!this.file) {
    this.message = "Silakan pilih file terlebih dahulu!";
    return;
  }

  const formData = new FormData();
  formData.append("bukti_pembayaran", this.file);

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

  try {
    const response = await fetch("http://127.0.0.1:8000/reservasi/upload-bukti", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": csrfToken,
      },
      body: formData,
    });

    if (response.ok) {
      const data = await response.json();
      this.message = "Bukti pembayaran berhasil diunggah! Mengarahkan ke halaman utama...";
      console.log(data);

      // Berikan jeda 3 detik sebelum mengarahkan ke /home
      setTimeout(() => {
        window.location.href = "/home";
      }, 3000); // Jeda 3 detik
    } else {
      const errorData = await response.json();
      this.message = `Error: ${errorData.message}`;
      console.error(errorData);
    }
  } catch (error) {
    this.message = "Terjadi kesalahan saat mengunggah bukti pembayaran.";
    console.error(error);
  }
}
,
  },
};
</script>

<style scoped>
h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}
button {
  padding: 0.5rem 1rem;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background-color: #45a049;
}
.notification {
  margin-top: 1rem;
  font-size: 1rem;
  color: #4caf50;
}
</style>
