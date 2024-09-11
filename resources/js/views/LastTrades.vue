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
      ticker: 'RUA1L'
    }
  }
}
</script>
<template>
  <header class="flex flex-auto mt-2 columns-2 justify-center">
    <form class="columns-2 w-auto mt-2" @submit.prevent="getTrades">
      <div class="form-data w-full h-12">
        <input class="rounded-md border-1 bg-gradient-to-tl h-full from-cyan-400 to-blue-200
                 focus:border-lime-400 text-center" v-model="ticker" type="text" placeholder="TICKER">
      </div>
      <button type="submit" class="text-white bg-gradient-to-r
                from-cyan-400 via-cyan-500 to-cyan-600
                hover:bg-gradient-to-l
                focus:outline-none focus:ring-pink-300
                dark:focus:ring-cyan-800 font-medium rounded-lg
                px-4 py-3 hover:shadow-gray-300  text-center me-2">
        Go LastTrades
      </button>
    </form>
  </header>
  <table class="table-auto">
    <thead>
      <tr>
        <th class="border border-slate-600 ...">Куплено</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="price, count  in trades.buy">
        <td class="border border-slate-700 ...">{{ count }} + {{ price }}</td>
      </tr>
    </tbody>
  </table>
  <table class="table-auto">
    <thead>
      <tr>
        <th class="border border-slate-600 ...">Продано</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="price, count  in trades.sell">
        <td class="border border-slate-700 ...">{{ count }} - {{ price }}</td>
      </tr>
    </tbody>
  </table>
</template>
