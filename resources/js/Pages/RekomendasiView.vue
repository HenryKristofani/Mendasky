<template>
    <div class="max-w-6xl mx-auto p-8">
      <!-- Section Header -->
      <h1 class="text-4xl font-semibold text-center text-gray-800 mb-12">Rekomendasi Pendakian 7 Hari Kedepan</h1>
  
      <!-- List Recommendations -->
      <section class="space-y-8">
        <div v-for="(day, index) in recommendations" :key="index" class="flex flex-col p-8 bg-white shadow-2xl rounded-lg border border-gray-300 hover:shadow-2xl transition-all">
          
          <!-- Date Section -->
          <p class="text-2xl font-semibold text-gray-700">{{ day.date }}</p>
  
          <!-- Jumlah Pendaki -->
          <p class="text-lg text-gray-600">Jumlah Pendaki: <span class="font-bold">{{ day.kuota }} pendaki</span></p>
  
          <!-- Cuaca -->
          <p class="text-lg text-gray-600">Cuaca: <span class="font-semibold">{{ day.weather }}</span></p>
  
          <!-- Rekomendasi -->
          <p class="text-lg text-gray-600">Rekomendasi: 
            <span v-for="n in day.stars" :key="n" class="text-yellow-500">&#9733;</span> <!-- Yellow star -->
          </p>
  
          <!-- Conditional: If the recommendation is low, add a warning -->
          <div v-if="day.stars === 1" class="mt-4 text-red-500 font-semibold">
            <p>Perhatikan cuaca atau kuota, pendakian kurang disarankan pada hari ini!</p>
          </div>
          
          <!-- Beautiful Divider -->
          <hr class="my-6 border-t-2 border-gray-200" />
        </div>
      </section>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  
  export default {
    name: 'RekomendasiView',
    setup() {
      const recommendations = ref([]);
  
      // Ambil data cuaca dan kuota
      const getRecommendations = async () => {
        const today = new Date();
        const startDate = new Date(today);
        let dataRecommendations = [];
  
        // Ambil data untuk 7 hari kedepan
        for (let i = 0; i < 7; i++) {
          let currentDate = new Date(startDate);
          currentDate.setDate(startDate.getDate() + i);
  
          // Format tanggal menjadi YYYY-MM-DD
          const formattedDate = currentDate.toISOString().split('T')[0];
  
          // Ambil data cuaca dari API
          const weatherResponse = await fetch(`https://api.weatherapi.com/v1/forecast.json?key=69324fc30bc9458581865221241411&q=Tawangmangu&days=7&date=${formattedDate}`);
          const weatherData = await weatherResponse.json();
  
          // Ambil kuota dan anggota dari API yang sudah dibuat di Laravel
          const kuotaResponse = await fetch(`/get-kuota/${formattedDate}`);
          const kuotaData = await kuotaResponse.json();
  
          // Kalkulasi rekomendasi berdasarkan cuaca dan kuota
          const weatherScore = calculateWeatherScore(weatherData);
          const kuotaScore = calculateKuotaScore(kuotaData.pendaki);
  
          const stars = calculateStars(weatherScore, kuotaScore);
  
          // Simpan data hari, rekomendasi, cuaca, dan jumlah pendaki
          dataRecommendations.push({
            date: formattedDate,
            stars: stars,
            kuota: kuotaData.pendaki,
            weather: weatherData.forecast.forecastday[0].day.condition.text, // Cuaca
          });
        }
  
        // Menyimpan rekomendasi di state
        recommendations.value = dataRecommendations;
      };
  
      // Kalkulasi skor cuaca
      const calculateWeatherScore = (weatherData) => {
        const condition = weatherData.forecast.forecastday[0].day.condition.text.toLowerCase();
  
        // Penilaian berdasarkan cuaca
        if (condition.includes("sunny") || condition.includes("clear") || condition.includes("partly cloudy")) {
          return 4; // Cuaca cerah
        } else if (condition.includes("cloudy")) {
          return 3; // Cuaca sedikit berawan
        } else if (condition.includes("rain")) {
          return 1; // Hujan
        } else {
          return 2; // Cuaca mendung atau biasa
        }
      };
  
      // Kalkulasi skor kuota
      const calculateKuotaScore = (pendaki) => {
        // Jika kuota 0, otomatis nilai 4 (bintang 4)
        if (pendaki === 0) {
          return 4; // Kuota 0 = bintang 4
        } else if (pendaki <= 5) {
          return 3; // Kuota sangat rendah (lebih sedikit pendaki)
        } else if (pendaki <= 10) {
          return 2; // Kuota rendah
        } else if (pendaki <= 20) {
          return 1; // Kuota sedang
        } else {
          return 1; // Kuota penuh
        }
      };
  
      // Kalkulasi bintang berdasarkan skor cuaca dan kuota
      const calculateStars = (weatherScore, kuotaScore) => {
        const totalScore = weatherScore + kuotaScore;
        let stars = 0;
        
        // Tambahkan bintang sesuai dengan total skor
        if (totalScore >= 7) {
          stars = 4; // Sangat direkomendasikan (bintang 4)
        } else if (totalScore >= 5) {
          stars = 3; // Direkomendasikan (bintang 3)
        } else if (totalScore >= 3) {
          stars = 2; // Kurang direkomendasikan (bintang 2)
        } else {
          stars = 1; // Tidak direkomendasikan (bintang 1)
        }
  
        return stars;
      };
  
      // Jalankan fungsi saat komponen dimuat
      onMounted(() => {
        getRecommendations();
      });
  
      return { recommendations };
    }
  };
  </script>
  
  <style scoped>
  .recommendation-section {
    margin-top: 20px;
    padding: 20px;
    background-color: #f9fafb;
    border-radius: 12px;
  }
  
  .recommendation-item {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }
  
  .recommendation-item:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }
  
  h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
  }
  
  p {
    margin-bottom: 10px;
    font-size: 1.1rem;
    color: #555;
  }
  
  .text-yellow-500 {
    color: #facc15; /* Tailwind yellow color for stars */
  }
  
  hr {
    border-top: 2px solid #e5e7eb;
  }
  </style>
  