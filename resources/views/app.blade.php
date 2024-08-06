<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js','resources/css/tail.css', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    
    <body class="conteiner absolute top-0 w-[100%] min-h-screen h-auto
    fixed bg-gradient-to-br  from-slate-700 to-zinc-800"">
        @inertia
    </body>
</html>
