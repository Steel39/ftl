<template class="bg-white">
  <header class="w-full bg-blue-300 h-auto bg-gradient-to-tl fixed">
    <div class="px-8 sm:px-6 lg:px-8 py-2 ">

      <!-- Page header -->
      <div class=" sm:flex sm:justify-between sm:items-center">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0 ">
          <RouterLink to="/">
            <h1 class=" text-2xl rounded-md  text-stone-900 bg-gradient-to-r from-cyan-300
                        to-blue-400  font-bold shadow-md shadow-slate-600 hover:shadow-cyan-400">MoscowExchangeLab</h1>
          </RouterLink>

        </div>
        <div class="bg-gray-950 rounded-md py-1 basis-1/2 text-center">
          <span class="font-sans text-xl text-lime-300">Окно уведомлений в разработке...</span>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-auto justify-start sm:justify-end gap-2 content-stretch
                     antialiased  font-sans text-shadow-lg text-violet-100">
          <RouterLink class="hover:shadow-cyan-400 text-gray-300 shadow-md shadow-slate-600 rounded-md" to="/">Home
          </RouterLink>
          <RouterLink class="hover:shadow-cyan-400 text-gray-300 shadow-md shadow-slate-600 rounded-md" to="/stocks">
            Stocks</RouterLink>
          <RouterLink class="hover:shadow-cyan-400 text-gray-300 shadow-md shadow-slate-600 rounded-md" to="/last_trades">
            Last Trade</RouterLink>
          <RouterLink class="hover:shadow-cyan-400 text-gray-300 shadow-md shadow-slate-600 rounded-md" to="/test"> Test
          </RouterLink>

        </div>
      </div>
    </div>
  </header>
  <main class="overscroll-auto h-auto  my-20 mx-8">
    <RouterView />
  </main>

  <footer class="flex-auto justify-center h-auto mx-8 text-3xl">

  </footer>
</template>
<script setup>

</script>
