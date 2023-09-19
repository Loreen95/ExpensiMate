<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     @vite('resources/css/app.css')
     @vite('resources/css/style.css')
    <title>ExpensiMate</title>
</head>
<body>
    @include('cookie-consent::index')
        <header class="h-15 bg-text" id="mainHeader">
            @include('layout.header')
        </header>
        <main class="h-screen border border-gray-500">
            <div class="flex justify-center items-center" id="content">
            @yield('content')
            </div>
        </main>
        <footer class="h-15 ">          
            @include('layout.footer')   
        </footer>
</body>
<script src="{{ asset('js/script.js') }}"></script>
</html>
