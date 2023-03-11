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
        <p  class="mr-3">{{$user->name}}</p>
        <img referrerpolicy="no-referrer" class="rounded-full" width="40px" height="40px" alt="profile pic" src="{{$user->avatar}}">
    </div>

    <form method="post" action="{{url('shorten')}}">
        @csrf
        <div class="flex">
            <input type="text" id="url" name="url"
                   class=" mr-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   placeholder="Type your long url" required>
            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                Shorten
            </button>
        </div>

    </form>
    <br>
    <h1 class="text-2xl">My Urls</h1>
    <div class="flex flex-col">
        @foreach($myUrls as $url)
            <div class="p-4 shadow-md my-2 justify-center flex flex-col bg-white rounded">
                <p><span class="font-bold">Short: </span> http://localhost:8000/{{$url->short}}</p>
                <p><span class="font-bold">Destination: </span>: {{$url->destination}}</p>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Check statistics
                </button>
            </div>
        @endforeach

        @if(count($myUrls)==0)
            <p class="text-gray">You have no urls..</p>
        @endif
    </div>
</div>
</body>
</html>
