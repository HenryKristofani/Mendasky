import { createRouter, createWebHistory } from "vue-router";
import HomeBeforeView from "./Pages/HomeBeforeView.vue";

const routes = [
    { path: "/", component: HomeBeforeView }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
