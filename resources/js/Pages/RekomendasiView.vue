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

        <!-- Skor Rekomendasi SAW -->
        <p class="text-lg text-gray-600">
          Skor Rekomendasi SAW: <span class="font-bold">{{ day.sawScore.toFixed(2) }}</span>
        </p>

        <!-- Rekomendasi Bintang -->
        <p class="text-lg text-gray-600">Rekomendasi: 
          <span v-for="n in day.stars" :key="n" class="text-yellow-500">&#9733;</span>
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

    // Fungsi untuk memformat tanggal
    const formatDate = (date) => {
      const options = { day: 'numeric', month: 'long', year: 'numeric' };
      return new Intl.DateTimeFormat('id-ID', options).format(new Date(date));
    };

    // Kalkulasi skor cuaca
    const calculateWeatherScore = (weatherData) => {
      const condition = weatherData.forecast.forecastday[0].day.condition.text.toLowerCase();

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

    // Kalkulasi skor kuota - Diubah agar jumlah pendaki lebih banyak = skor lebih rendah
    const calculateKuotaScore = (pendaki) => {
      if (pendaki >= 20) {
        return 1; // Kuota penuh - skor terendah
      } else if (pendaki >= 10) {
        return 2; // Kuota sedang
      } else if (pendaki >= 5) {
        return 3; // Kuota rendah
      } else {
        return 4; // Kuota sangat rendah atau kosong - skor tertinggi
      }
    };

    // Kalkulasi SAW - Dimodifikasi untuk normalisasi yang benar
    const calculateSAWScore = (dataRecommendations) => {
      // Normalisasi skor cuaca (benefit)
      const maxWeatherScore = Math.max(...dataRecommendations.map(day => day.weatherScore));
      const normalizedWeatherScores = dataRecommendations.map(day => day.weatherScore / maxWeatherScore);

      // Normalisasi skor kuota (cost)
      const maxKuotaScore = Math.max(...dataRecommendations.map(day => day.kuotaScore));
      const normalizedKuotaScores = dataRecommendations.map(day => day.kuotaScore / maxKuotaScore);

      // Bobot
      const weightWeather = 0.6; // Bobot untuk cuaca
      const weightKuota = 0.4;   // Bobot untuk kuota

      // Hitung skor SAW
      dataRecommendations.forEach((day, index) => {
        const weatherNormalized = normalizedWeatherScores[index];
        const kuotaNormalized = normalizedKuotaScores[index];

        // Total skor dengan bobot
        day.sawScore = (weightWeather * weatherNormalized) + (weightKuota * kuotaNormalized);

        // Tambahkan bintang berdasarkan skor SAW
        if (day.sawScore >= 0.75) {
          day.stars = 4;
        } else if (day.sawScore >= 0.5) {
          day.stars = 3;
        } else if (day.sawScore >= 0.25) {
          day.stars = 2;
        } else {
          day.stars = 1;
        }
      });

      // Urutkan berdasarkan skor SAW (dari tinggi ke rendah)
      dataRecommendations.sort((a, b) => b.sawScore - a.sawScore);
    };

    // Ambil data cuaca dan kuota
    const getRecommendations = async () => {
      const today = new Date();
      const startDate = new Date(today);
      let dataRecommendations = [];

      // Ambil data untuk 7 hari ke depan
      for (let i = 0; i < 7; i++) {
        let currentDate = new Date(startDate);
        currentDate.setDate(startDate.getDate() + i);

        // Format tanggal menjadi YYYY-MM-DD
        const formattedDate = currentDate.toISOString().split('T')[0];

        // Ambil data cuaca dari API
        const weatherResponse = await fetch(`https://api.weatherapi.com/v1/forecast.json?key=69324fc30bc9458581865221241411&q=Tawangmangu&days=7&date=${formattedDate}`);
        const weatherData = await weatherResponse.json();

        // Ambil kuota dan anggota dari API Laravel
        const kuotaResponse = await fetch(`/get-kuota/${formattedDate}`);
        const kuotaData = await kuotaResponse.json();

        // Kalkulasi skor
        const weatherScore = calculateWeatherScore(weatherData);
        const kuotaScore = calculateKuotaScore(kuotaData.pendaki);

        // Simpan data
        dataRecommendations.push({
          date: formatDate(formattedDate),
          kuota: kuotaData.pendaki,
          weather: weatherData.forecast.forecastday[0].day.condition.text,
          weatherScore: weatherScore,
          kuotaScore: kuotaScore,
        });
      }

      recommendations.value = dataRecommendations;
      calculateSAWScore(dataRecommendations);
    };

    onMounted(() => {
      getRecommendations();
    });

    return { recommendations };
  },
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