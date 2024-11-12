import { createRouter, createWebHistory } from "vue-router";
import HomeBeforeView from "./Pages/HomeBeforeView.vue";
import HomeView from "./Pages/HomeView.vue";
import Login from "./Pages/LoginView.vue";
import Reservasi from "./Pages/ReservasiView.vue";
import ReservasiList from "./Pages/ReservasiListView.vue";
import EditReservasiView from "./Pages/EditReservasiView.vue"; // Import halaman edit reservasi
import Berita from "./Pages/BeritaView.vue";

const routes = [
    { path: "/", component: HomeBeforeView, name: "homeBefore" },
    { path: "/login", component: Login, name: "login" },
    { path: "/reservasi", component: Reservasi, name: "reservasi" },
    { path: "/home", component: HomeView, name: "home" },
    { path: "/reservasilist", component: ReservasiList, name: "reservasilist" },
    { path: "/reservasi/:id/edit", component: EditReservasiView, name: "reservasis.edit" },
    { path: "/berita", component: Berita, name: "berita" },
    { path: "/pembayaran/:id", component: Reservasi, name: "pembayaran.view" },
    
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
