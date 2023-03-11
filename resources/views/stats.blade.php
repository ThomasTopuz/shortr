<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div
    class="relative flex flex-col justify-center items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <h1 class="text-4xl">Url shortener</h1>
    <h2 class="text-2xl">Welcome</h2>
    <div class="flex shadow my-2 bg-white rounded p-2 items-center mb-5">
        <p class="mr-3">{{$user->name}}</p>
        <img referrerpolicy="no-referrer" class="rounded-full" width="60px" height="60px" alt="profile pic"
             src="{{$user->avatar}}">
    </div>
    <a type="submit" href="/"
       class="bg-orange-500 hover:bg-orange-400 text-white font-bold py-2 px-4 border-b-4 border-orange-700 hover:border-orange-500 rounded ">
        <-- Back to list
    </a>
    <br>
    <h1 class="text-2xl">Url statistics</h1>
    <div class="p-4 shadow-md my-2 justify-center flex flex-col bg-white rounded">
        <p><span class="font-bold">Short: </span> http://localhost:8000/{{$url->short}}</p>
        <p><span class="font-bold">Destination: </span>: {{$url->destination}}</p>
        <br>
        <hr>
        <br>
        <h3 class="text-xl font-bold">Number of clicks: {{$url->clicks}}</h3>

        <br>
        <hr>
        <br>
        <h3 class="text-xl font-bold">Operating systems</h3>
        @foreach($os as $osEntry)
            <p>{{$osEntry['name']}}: {{$osEntry['count']}}</p>
        @endforeach
        <br>
        <hr>
        <br>
        <h3 class="text-xl font-bold">Browsers</h3>
        <br>
        <hr>
        <br>
        <h3 class="text-xl font-bold">Geo locations</h3>
    </div>
</div>
</body>
</html>
