<script>
import axios from 'axios';
import { ref } from 'vue';


export default {
    data() {
        return {
            ticker: 'GAZP',
        }
    },
    methods: {
        getTrades() {
            axios.get('api/get_trades/' + this.ticker)
            .then((response => {
                
                console.log(response.data)
            }))
        }
    }
}

</script>
<template>
    <header class="flex flex-auto mt-2 columns-2">
        <form class="columns-2 w-full content-center" @submit.prevent="getTrades">
            <div class="form-data">
                <input class="appearance-none block w-full bg-pink-200 
                text-gray-700 border border-gray-200 rounded py-3 
                 leading-tight focus:outline-none focus:bg-gray-300
                 hover:shadow-emerald-300 focus:border-gray-500 text-center" 
                 v-model="ticker" type="text"
                    placeholder="TICKER">
            </div>
            <button type="submit" class="text-white bg-gradient-to-r
             from-cyan-400 via-cyan-500 to-cyan-600
              hover:bg-gradient-to-l 
              focus:outline-none focus:ring-pink-300
               dark:focus:ring-cyan-800 font-medium rounded-lg
                px-4 py-3  text-center me-2 ">Go LastTrades
            </button>
        </form>
    </header>
    <section class="flex flex-auto my-8">
        <div class="greed columns-">

        </div>
    </section>
</template>