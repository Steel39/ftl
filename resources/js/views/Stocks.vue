<template>
    <button @click="load">Загрузка данных</button>

    <div class="server-response flex flex-row columns-4  rounded-md mx-auto ">
        <button
            class="hover:bg-lime-200/100 shadow-lg shadow-gray-600 text-gray-700 mx-2  my-[3px] bg-gray-300/100  border-2 border-white-400 rounded-xl font-sans">
            <p class="mx-4 text-2xl">{{ trades.ticker }}</p>
            <p class="mx-4">{{ trades.price }}</p>
        </button>

    </div>
</template>
<script>

import axios from 'axios'
axios.defaults.withCredentials = true
import { ref } from 'vue'

export default {
    name: "Stocks",
    setup() {

        const trades = ref([])

        function onSuccess(response) {
            trades.value = response.data;
        }

        function load() {
            axios.get('/api/stocks')
                .then(onSuccess)
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        return {
            load,
            trades
        }
    }
}

</script>