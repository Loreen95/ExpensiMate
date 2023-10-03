<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     @vite('resources/css/app.css')
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.11.0/css/flag-icons.min.css"/>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
     <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
    <title>ExpensiMate</title>
</head>
<body class="bg-silver">
    <div class="cookie-consent-container">
        @include('cookie-consent::index')
    </div>
    
    <header class="h-15 bg-oxford" id="mainHeader">
        @include('layout.header')
    </header>

    @auth
        @include('finance.navbar') 
    @endauth

    <main class="flex-1">
        <div class="flex justify-center items-center" id="content">
            @yield('content')
        </div>
    </main>
    
    <footer class="h-12 bg-accent">          
        @include('layout.footer')   
    </footer>
</body>
</html>