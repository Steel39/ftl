<template>
    <div class="flex h-screen overflow-hidden">
  
      <!-- Sidebar -->
    
  
      <!-- Content area -->
      <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-gradient-to-br  from-sky-300   to-fuchsia-300">
        
        <!-- Site header -->
    
  
        <main>
          <div class="px-4 sm:px-6 lg:px-8 py-2 w-full max-w-9xl mx-auto ">
  
            <!-- Page header -->
            <div class="sm:flex sm:justify-between sm:items-center mb-5">
            
              <!-- Left: Title -->
              <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl rounded-md  text-gray-700 bg-gradient-to-r from-indigo-300 
                to-purple-400  font-bold shadow-xl">FintechLab</h1>
              </div>
  
              <!-- Right: Actions -->
              <div class=" grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <RouterLink class="antialiased font-sans text-gray-800 shadow-lg" to="/">Home</RouterLink>
                <RouterLink class="antialiased font-sans text-gray-800 shadow-lg" to="/stocks">Stocks</RouterLink>
              </div>
  
            </div>
  
            <!-- Cards -->
            <div class="grid grid-cols-12 gap-6">
            <RouterView />
  
            </div>
  
          </div>
        </main>
  
      </div> 
  
    </div>
  </template>