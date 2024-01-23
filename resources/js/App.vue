<template>
  <header class=" bg-blue-400 bg-gradient-to-tl from-orange-300 
    to-purple-400">
    <div class="px-4 sm:px-6 lg:px-8 py-2 ">

      <!-- Page header -->
      <div class=" sm:flex sm:justify-between sm:items-center">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0 ">
          <h1 class=" text-2xl md:text-3xl rounded-md   text-gray-700 bg-gradient-to-r from-indigo-300
    to-purple-400  font-bold shadow-xl hover:shadow-emerald-300">FinTechLab</h1>
        </div>

        <!-- Right: Actions -->
        <div class=" grid grid-flow-col sm:auto-cols-auto justify-start sm:justify-end gap-2">
          <RouterLink class="antialiased hover:shadow-cyan-400 rounded-md font-sans text-gray-800 shadow-lg" to="/">Home
          </RouterLink>
          <RouterLink class="antialiased hover:shadow-cyan-400 rounded-md font-sans text-gray-800 shadow-lg" to="/stocks">
            Stocks</RouterLink>
          <RouterLink class="antialiased hover:shadow-cyan-400 rounded-md font-sans text-gray-800 shadow-lg" to="/test">
            Test</RouterLink>
        </div>
      </div>
    </div>
  </header>
  <div class="flex h-screen overflow-hidden bg-gradient-to-bl from-orange-300 to-purple-400">
    <main class="mx-8">
      <RouterView />
    </main>
  </div>
</template>
