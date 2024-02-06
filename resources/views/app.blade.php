<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title class="text-blue">FinTechLab</title>
    <script src={{ asset('../../../node_modules/flowbite/dist/flowbite.min.js') }}></script>
    @vite('resources/css/tail.css')
</head>
<body >
<div id="app" class="conteiner absolute top-0 w-[100%] min-h-screen h-auto
                     fixed bg-gradient-to-br  from-slate-950 to-teal-950"
                     ></div>

@vite('resources/js/app.js')
</body>
</html>