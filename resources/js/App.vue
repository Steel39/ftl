<template >
    <header class="w-full bg-blue-700 h-auto bg-gradient-to-tl fixed">
      <div class="px-8 sm:px-6 lg:px-8 py-2 ">

        <!-- Page header -->
        <div class=" sm:flex sm:justify-between sm:items-center">

          <!-- Left: Title -->
          <div class="mb-4 sm:mb-0 ">
            <h1 class=" text-2xl rounded-md   text-gray-700 bg-gradient-to-r from-cyan-300
                        to-emerald-400  font-bold shadow-lg hover:shadow-emerald-300">FinTechLab</h1>
          </div>

          <!-- Right: Actions -->
          <div class="grid grid-flow-col sm:auto-cols-auto justify-start sm:justify-end gap-2
                     antialiased  font-sans text-shadow-lg text-violet-100">
            <RouterLink class="hover:shadow-cyan-400 shadow-lg rounded-md" to="/">Home </RouterLink>
            <RouterLink class="hover:shadow-cyan-400 shadow-lg rounded-md" to="/stocks">Stocks</RouterLink>
            <RouterLink class="hover:shadow-cyan-400 shadow-lg rounded-md" to="/last_trades">Last Trade</RouterLink>
            <RouterLink class="hover:shadow-cyan-400 shadow-lg rounded-md" to="/test"> Test</RouterLink>
             
          </div>
        </div>
      </div>
    </header>
    <main class="overscroll-auto h-auto  my-20 mx-8">
      <RouterView />
    </main>

    <footer class="flex-auto justify-center h-auto mx-8 text-3xl">
      footer
    </footer>
</template>
