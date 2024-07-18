<template>
    <section class="">
        <header class="">
            <div class="flex flex-auto gap-4">
                <button @click="" class="bg-gray-400 hover:bg-slate-400 active:shadow-none

                 text-gray-800 font-semibold py-2 px-4 rounded-md shadow-md shadow-gray-100">
                    Обновить
                </button>
                <button @click="showStocks" class="bg-gray-400 hover:bg-slate-400 active:shadow-none

                 text-gray-800 font-semibold py-2 px-4 rounded-md shadow-md shadow-gray-100">
                    Показать
                </button>
                <button @click="setStocks" class="bg-gray-400 hover:bg-slate-400 active:shadow-none
                 text-gray-800 font-semibold py-2 px-4 rounded-md shadow-md shadow-gray-100">
                    Все
                </button>
                <button @click="setActiveShares" class="bg-gray-400 hover:bg-slate-400 active:shadow-none
                 text-gray-800 font-semibold py-2 px-4 rounded-md shadow-md shadow-gray-100">
                    Торгующиеся
                </button>
                <button @click="" class="bg-gray-400 hover:bg-slate-400 active:shadow-none
                 text-gray-800 font-semibold py-2 px-4 rounded-md shadow-md shadow-gray-100">
                    Внебиржевые
                </button>
                <button @click="destroy" class="bg-gray-400 hover:bg-slate-400 active:shadow-none
                 text-gray-800 font-semibold py-2 px-4 rounded-md shadow-md shadow-gray-100">
                    Удалить
                </button>
                
                <div class="bg-gray-900 rounded-md py-2 basis-full text-center">
                    <span class="font-sans text-emerald-400">{{ this.status }}</span>
                </div>
            </div>
            <div class="flex flex-auto gap-4 py-4">
                
            </div>
        </header>
        <div class="grid md:grid-cols-6 grid-cols-3 gap-4 py-10">
            <div v-for="data in dataStocks">
                <button class="shadow-xl shadow-green-400 my-2 h-44 w-44 px-5 bg-gradient-to-bl
                       from-slate-800  to-stone-400 border-spacing-10 rounded-full hover:bg-black">
                    <div class="">
                        <p class="font-semibold mx-auto text-center"><i class="font-semibold text-lime-400 text-center">
                                {{ data.ticker }}</i></p>
                        <p class="font-sans text-center"><i class="font-semibold text-gray-200 text-center">
                                +2,3%
                            </i></p>
                        <p class="font-sanstext-center">
                            <b class="font-sans text-green-200 text-center">81489</b>/
                            <b class="font-sans text-red-300 text-center">5698</b>
                        </p>
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
        const status = ref()
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
                    console.log(this.resultSetStocks)
                })
                .catch((error) => { alert(`Error ${error.message}`) })
        }

        function showStocks() {
            axios.get('api/showStocks')
                .then(response => {
                    dataStocks.value = response.data
                    this.status = `Акций загружено: ${dataStocks.value.length}`
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

        return {
            load,
            setStocks,
            showStocks,
            destroy,
            setActiveShares,
            status,
            shares,
            share,
            stock,
            data,
            resultSetStocks,
            resultDestroyStocks,
            dataStocks,
        }
    }
}

</script>
