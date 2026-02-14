

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex justify-center p-5 sm:justify-center items-center pt-6 inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] bg-size-[16px_16px] sm:pt-0 absolute">

            <!-- container Form -->
            <div class="w-full max-w-[1600px] min-h-[600px] rounded-2xl sm:max-w-3xl mx-auto bg-[#111111] overflow-hidden sm:rounded-lg grid grid-cols-1 lg:grid-cols-2 items-center">
            <!-- IMG Login -->
            <div class="img relative w-full h-full hidden lg:block">
                <img src="https://i.pinimg.com/1200x/31/6b/ad/316bad59032b499160d768e6c4a4778d.jpg" alt="" class="absolute inset-0 w-full h-full object-cover ">
            </div>
            <!-- Input -->
                {{ $slot }}

            <!-- BTN Google -->
            <div class="bg-white flex justify-center items-center rounded-2xl py-1 mt-6 hover:text-[#9a0002] hover:scale-105 transition duration-300 ease-in-out">
                <i class="fa-brands fa-google mx-2"></i>
                <a href="{{ route('google.redirect') }}">Login With Google</a>
            </div>
        
            </div>
                
            

            </div>
        </div>
    </body>
</html>
