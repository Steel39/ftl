<template class="grid grid-auto bg-gradient-to-br from-blue-200 to-black ">
        <section class=" bg-black">
            <header class="bg-gradient-to-br from-blue-700 to-black ">
                <div class="grid grid-2 gap-4">
                    <button @click="getTradesData" class="mt-5 ml-5 mr-5 bg-gray-400 hover:bg-slate-400 active:shadow-none

                 text-gray-800 font-semibold py-2 px-4 rounded-md shadow-md shadow-gray-100">
                        Обновить
                    </button>
                    <div class="ml-5 mr-5  bg-black rounded-md mt-5 py-1 basis-1/2 text-center">
                        <span class="font-sans text-xl text-cyan-300">
                            {{ dataStocks.time }} - {{ dataStocks.lastTimeTrade }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-auto gap-4 py-4">

                </div>
            </header>
            <div class="grid md:grid-cols-8 grid-cols-3 gap-4 px-10 py-10">
                <div v-for="data in dataStocks.trades">
                    <button :class="`shadow-xl  active:shadow-inner hover:bg-black shadow-${data.color}-${data.intense} my-2 h-32 w-32 px-5 bg-gradient-to-bl
                       from-zinc-800  to-slate-700 border-spacing-10 rounded-md`">
                        <p class="font-semibold  mx-auto"><i class="font-semibold text-blue-400 ">
                                {{ data.ticker }}</i></p>
                        <p class="font-sans "><i class="font-semibold text-gray-200 ">
                            </i></p>
                        <p class="font-sans">
                            <b class="font-sans  text-lime-400 ">{{ data.allBuy }}</b>
                        </p>
                        <p class="font-sans">
                            <b class="font-sans text-red-500 ">{{ data.allSell }}</b>
                        </p>
                        <p class="font-sans">
                            <b :class="`font-sans text-${data.differentColor}-600`">{{ data.different }}%</b>
                        </p>
                    </button>
                </div>
            </div>
        </section>
</template>
<script>

import axios from 'axios'
axios.defaults.withCredentials = true
import { ref } from 'vue'
import { inject } from 'vue'

export default {
    name: "Stocks",
    setup() {

        const status = inject('status')
        const share = ref([])
        const stock = ref([])
        const data = ref([])
        const shares = ref([])
        const dataStocks = ref([])
        const tradesData = ref([])
        const count = ref([])



        function load() {
            axios.get('/api/stocks')
                .then(response => {
                    this.shares = response.data
                    console.log(shares.value)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }
        function setActiveShares() {
            this.status = "Загружаю актуальные акции, ожидайте..."
            axios.get('/api/setActive')
                .then(response => {
                    this.status = response.data
                })
                .catch((error) => { alert(`Error ${error.message}`), this.status = `Ошибка загрузки ${error.message}` })
        }

        function setStocks() {
            this.status = "Ожидайте ответа от сервера Т"
            axios.get('api/setStocks')
                .then(response => {
                    this.status = response.data
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        function showStocks() {
            axios.get('api/showStocks')
                .then(response => {
                    this.dataStocks = response.data
                    this.status = `Обновлено: ${dataStocks.value.length}`
                    console.log(dataStocks)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        function destroy() {
            axios.delete('api/destroy')
                .then(response => {
                    this.status = response.data
                    console.log(this.resultDestroyStocks)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }
        function getStream() {
            axios.get('api/getStream')
                .then(response => {
                    //this.status = response.data
                    //console.log(this.resultDestroyStocks)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        function getTradesData() {
            this.status = "Получаем данные..."
            axios.get('api/getTradesData')
                .then(response => {
                    this.dataStocks = response.data
                    this.count = Object.keys(this.dataStocks.trades).length
                    this.status = `Обновлено: ${this.count}`;
                    console.log(this.dataStocks.trades
                    )
                })
        }
        function destroyHashMemory() {
            this.status = "Чищу хэши"
            axios.get('api/destroyHashMemory')
                .then(response => {
                    this.status = response.data.status
                    this.dataStocks.time = response.data.time
                    this.getTradesData()
                })
        }

        return {
            load,
            count,
            setStocks,
            showStocks,
            destroy,
            getStream,
            setActiveShares,
            getTradesData,
            destroyHashMemory,
            tradesData,
            status,
            shares,
            share,
            stock,
            data,
            dataStocks,
        }
    }
}

</script>
