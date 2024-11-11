import { createRouter, createWebHistory } from "vue-router";
import HomeBeforeView from "./Pages/HomeBeforeView.vue";
import HomeView from "./Pages/HomeView.vue";
import Login from "./Pages/LoginView.vue";
import Reservasi from "./Pages/ReservasiView.vue";
import ReservasiList from "./Pages/ReservasiListView.vue";
import EditReservasiView from "./Pages/EditReservasiView.vue"; // Import halaman edit reservasi
import IsiBerita from "./Pages/Berita/isiberita.vue";

const routes = [
    { path: "/", component: HomeBeforeView, name: "homeBefore" },
    { path: "/login", component: Login, name: "login" },
    { path: "/reservasi", component: Reservasi, name: "reservasi" },
    { path: "/home", component: HomeView, name: "home" },
    { path: "/reservasilist", component: ReservasiList, name: "reservasilist" },
    { path: "/reservasi/:id/edit", component: EditReservasiView, name: "reservasis.edit" },
    { path: "/berita", component: IsiBerita, name: "berita" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
