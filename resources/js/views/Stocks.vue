<template>
    <header class="flex flex-auto">
        <div class="">
            
        </div>
        <div class="">
        </div>
    </header>
    <div>
        <button class="flex flex-row space-x-6 hover:bg-lime-200/100 shadow-lg
                       shadow-gray-600 text-gray-800 my-4 bg-gray-200/100  border-2
                       border-blue-200 rounded-md font-sans">
            <div>
                <p class="font-bold mx-auto text-left">Ticker</p>
                <p class="font-bold text-left ">Price</p>
                <p class="font-bold text-left">Diff, %</p>
                <p class="font-bold text-left ">Buy</p>
                <p class="font-bold text-left ">Sell</p>
            </div>
            <div>
                <p class="font-bold text-blue-600 text-right">GAZP</p>
                <p class="font-bold text-right text-indigo-600">200</p>
                <p class="font-bold text-violet-600 text-right">0.2</p>
                <p class="font-bold text-right text-green-600">352</p>
                <p class="font-bold text-right text-red-600">1120</p>
            </div>
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