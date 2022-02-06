<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Number Trivia</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased">
<div class="relative py-4">

    <div class="row">
        <h1 class="text-center">
            <a href="{{route('home')}}" class="text-decoration-none text-black">NUMBER TRIVIA</a>
        </h1>
    </div>
    @yield('content')
</div>
</body>
</html>