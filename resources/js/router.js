import { createRouter, createWebHistory } from "vue-router";
import HomeBeforeView from "./Pages/HomeBeforeView.vue";
import Login from "./Pages/LoginView.vue";

const routes = [
    { path: "/", component: HomeBeforeView },
    { path: "/login", component: Login}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
