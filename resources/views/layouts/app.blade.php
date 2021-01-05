<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/suilven/boris/css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('vendor/suilven/boris/js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">

<hr/>

<div class="flex justify-between text-sm text-gray-700">
    <div class="flex items-center">
        <a class="block p-3">About</a>
        <a class="block p-3">Store</a>
    </div>

    <div class="flex items-center">
        <a class="block p-3">Gmail</a>
        <a class="block p-3">Images</a>
        <img class="rounded-full block py-3 px-4" src="https://lh3.googleusercontent.com/-qKDxtPVf3MA/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rdxXjFhEvxN4q1JUHeo4xlUIanULA.CMID/s64-c/photo.jpg">
    </div>
</div>




<!-- Page Content -->
<main>
    {{ $slot }}
</main>

<!-- footer -->
<div class="fixed bottom-0 bg-gray-200 border-t w-full flex justify-between text-gray-600 text-xs">
    <div class="flex">
        <a class="block p-3">Advertising</a>
        <a class="block p-3">Business</a>
        <a class="block p-3">How Search Works</a>
    </div>
    <div class="flex">
        <a class="block p-3">Privacy</a>
        <a class="block p-3">Terms</a>
        <a class="block p-3">Settings</a>
    </div>
</div>


</body>
</html>