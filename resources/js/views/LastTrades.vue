<script >
import axios from 'axios';
import { ref } from 'vue';
import { onMounted } from 'vue';
axios.defaults.withCredentials = true


export default {
  name: 'LastTrades',

  setup() {

    const trades = ref([])

    function getTrades() {
      axios.get('api/get_trades/' + this.ticker)
        .then((response => {
          trades.value = response.data
          console.log(trades)
        }))
    }


    return {
      trades,
      getTrades,
      ticker: 'RUAL'
    }
  }
}
</script>
<template>
  <header class="flex flex-auto mt-2 columns-2 justify-center">
    <form class="columns-2 w-auto mt-2" @submit.prevent="getTrades">
      <div class="form-data w-full h-12 bg-slate-800">
        <input class="w-full bg-gradient-to-r h-full from-amber-400 to-yellow-200
                 focus:border-gray-500 rounded-lg text-center" v-model="ticker" type="text" placeholder="TICKER">
      </div>
      <button type="submit" class="text-white bg-gradient-to-r
                from-cyan-400 via-cyan-500 to-cyan-600
                hover:bg-gradient-to-l
                focus:outline-none focus:ring-pink-300
                dark:focus:ring-cyan-800 font-medium rounded-lg
                px-4 py-3 hover:shadow-emerald-300  text-center me-2">
        Go LastTrades
      </button>
    </form>
  </header>
  <section class="grid grid-cols-2 gap-2 my-8 bg-emerald-200">
    <div v-for="price, count  in trades.buy" class="">
      <div >
        <p>
          {{ count }} + {{ price }}
        </p>
      </div>
    </div>
    <div v-for="price, count in trades.sell" class="">
      {{ count }} - {{ price }}
    </div>
  </section>
</template>
