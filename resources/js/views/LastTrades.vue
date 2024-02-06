<script >
import axios from 'axios';
import { ref } from 'vue';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
axios.defaults.withCredentials = true


export default {
  name: 'LastTrades',

  setup() {
    onMounted(() => {
      initFlowbite();
    })

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
    // ApexCharts options and config
    window.addEventListener("load", function () {
      let options = {
        // set this option to enable the tooltip for the chart, learn more here: https://apexcharts.com/docs/tooltip/
        tooltip: {
          enabled: true,
          x: {
            show: true,
          },
          y: {
            show: true,
          },
        },
        grid: {
          show: false,
          strokeDashArray: 4,
          padding: {
            left: 2,
            right: 2,
            top: -26
          },
        },
        series: [
          {
            name: "Developer Edition",
            data: [1500, 1418, 1456, 1526, 1356, 1256],
            color: "#1A56DB",
          },
          {
            name: "Designer Edition",
            data: [643, 413, 765, 412, 1423, 1731],
            color: "#7E3BF2",
          },
        ],
        chart: {
          height: "100%",
          maxWidth: "100%",
          type: "area",
          fontFamily: "Inter, sans-serif",
          dropShadow: {
            enabled: false,
          },
          toolbar: {
            show: false,
          },
        },
        legend: {
          show: true
        },
        fill: {
          type: "gradient",
          gradient: {
            opacityFrom: 0.55,
            opacityTo: 0,
            shade: "#1C64F2",
            gradientToColors: ["#1C64F2"],
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          width: 6,
        },
        xaxis: {
          categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February', '07 February'],
          labels: {
            show: false,
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        yaxis: {
          show: false,
          labels: {
            formatter: function (value) {
              return '$' + value;
            }
          }
        },
      }

      if (document.getElementById("tooltip-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("tooltip-chart"), options);
        chart.render();
      }
    });
  }
}
// ApexCharts options and config
window.addEventListener("load", function () {
  let options = {
    // set this option to enable the tooltip for the chart, learn more here: https://apexcharts.com/docs/tooltip/
    tooltip: {
      enabled: true,
      x: {
        show: true,
      },
      y: {
        show: true,
      },
    },
    grid: {
      show: true,
      strokeDashArray: 4,
      padding: {
        left: 2,
        right: 2,
        top: -26
      },
    },
    series: [
      {
        name: "Developer Edition",
        data: [1500, 1418, 1456, 1526, 1356, 1256],
        color: "#1A56DB",
      },
      {
        name: "Designer Edition",
        data: [643, 413, 765, 412, 1423, 1731],
        color: "#7E3BF2",
      },
    ],
    chart: {
      height: "100%",
      maxWidth: "100%",
      type: "area",
      fontFamily: "Inter, sans-serif",
      dropShadow: {
        enabled: false,
      },
      toolbar: {
        show: false,
      },
    },
    legend: {
      show: true
    },
    fill: {
      type: "gradient",
      gradient: {
        opacityFrom: 0.55,
        opacityTo: 0,
        shade: "#1C64F2",
        gradientToColors: ["#1C64F2"],
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: 6,
    },
    xaxis: {
      categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February', '07 February'],
      labels: {
        show: true,
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      show: false,
      labels: {
        formatter: function (value) {
          return '$' + value;
        }
      }
    },
  }

  if (document.getElementById("tooltip-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("tooltip-chart"), options);
    chart.render();
  }
});
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
  <section class="my-8 justify-center bg-gray-300 columns-2">
    <div v-for="price, count  in trades.buy" class="flex flex-auto">
      {{ count }} + {{ price }}
    </div>
    <div v-for="price, count in trades.sell" class="flex flex-auto">
      {{ count }} - {{ price }}
    </div>
  </section>
</template>