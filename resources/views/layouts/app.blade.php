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
    <link rel="stylesheet" href="{{ asset('vendor/suilven/flickr-editor/css/app.css') }}">


</head>
<body class="font-sans antialiased">





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