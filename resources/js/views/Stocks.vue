<template>
    <section class="">
        <header class="">
            <div class="grid 2xl:grid-cols-5 gap-4">
                <button @click="showStocks"
                    class="bg-amber-400 hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-md shadow">
                    Показать
                </button>
                <button @click="setStocks"
                    class="bg-amber-400 hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-md shadow">
                    Загрузить все
                </button>
                <button @click=""
                        class="bg-amber-400 hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-md shadow">
                    Загрузить
                </button>
                <button @click="destroy"
                    class="bg-amber-400 hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-md shadow">
                    Удалить
                </button>
                <div class="bg-gray-900 rounded-md text-center py-4 lg:px-4">
                        <span class="font-semibold mr-2 text-green-400 text-left flex-auto">Статус</span>

                    </div>
                </div>
        </header>
        <div class="grid grid-cols-6 gap-4">
            <div v-for="data in dataStocks">
                <button class="flex flex-row space-x-6 hover:bg-lime-200/100 shadow-lg
                       shadow-gray-600 text-gray-800 my-4 bg-gray-200/100  border-2
                       border-blue-200 rounded-md font-sans">
                    <div>
                        <p class="font-bold mx-auto text-left">Тикер <i
                                class="font-bold text-green-600 text-right">{{ data.ticker }}</i> </p>
                        <p class="font-bold text-left ">Название <i
                                class="font-bold text-center text-blue-600">{{ data.name }}</i></p>
                        <p class="font-bold text-left">Всего выпущено <i
                                class="font-bold text-violet-600 text-right">{{ data.issue_size }}</i></p>
                    </div>
                </button>
            </div>
        </div>

    </section>
</template>
<script>

import axios from 'axios'
axios.defaults.withCredentials = true
import { ref } from 'vue'

export default {
    name: "Stocks",
    setup() {

        const share = ref([])
        const stock = ref([])
        const data = ref([])
        const shares = ref([])
        const resultSetStocks = ref([])
        const resultDestroyStocks = ref([])
        const dataStocks = ref([])

        function onSuccess(response) {
            trades.value = response.data;
        }

        function load() {
            axios.get('/api/stocks')
                .then(response => {
                    this.shares = response.data
                    console.log(shares.value)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        function setStocks() {
            axios.get('api/setStocks')
                .then(response => {
                    this.resultSetStocks = response.data
                    console.log(this.resultSetStocks)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        function showStocks() {
            axios.get('api/showStocks')
                .then(response => {
                    dataStocks.value = response.data
                    console.log(dataStocks)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        function destroy() {
            axios.delete('api/destroy')
                .then(response=> {
                    this.resultDestroyStocks = response.data
                    console.log(this.resultDestroyStocks)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        return {
            load,
            setStocks,
            showStocks,
            destroy,
            shares,
            share,
            stock,
            data,
            resultSetStocks,
            resultDestroyStocks,
            dataStocks
        }
    }
}

</script>
