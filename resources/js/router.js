import { createWebHistory, createRouter } from "vue-router";
import Home from '@/views/Home.vue'
import Stocks from '@/views/Stocks.vue'
import Test from '@/views/Test.vue'
import LastTrades from '@/views/LastTrades.vue'

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
    },
    {
        path: "/last_trades",
        name: "LastTrades",
        component: LastTrades,
    },
    {
        path: "/test",
        name: "Test",
        component: Test,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
