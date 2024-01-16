import { createWebHistory, createRouter } from "vue-router";
import Home from '@/views/Home.vue'
import Stocks from '@/views/Stocks.vue'

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/stocks",
        name: "Stocks",
        component: Stocks,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;