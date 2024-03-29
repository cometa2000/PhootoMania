

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        @stack('styles')
        <title>FotoManía - @yield('titulo')</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        @vite('resources/js/app.js')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="bg-gray-200">
        <header class="p-5 border-b bg-white shadow">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-3xl font-black">
                    <i class="fa-brands fa-laravel"></i>
                    <span class="italic">PhootoMania</span>
                </a>
                <nav class="flex gap-2 items-center">
                    @auth
                    <a href="{{ route('posts.create') }}" class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer ml-3 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Crear
                    </a>
                    <a class="font-bold text-gray-600 text-sm ml-3 mr-3" href="{{ route('posts.index', ['user'=> auth()->user()]) }}">{{ '@'.auth()->user()->username }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="font-bold uppercase text-gray-600 text-sm ml-3 mr-3">Cerrar sesión</button>
                    </form>
                    @endauth

                    @guest
                    <a class="font-bold uppercase text-gray-600 text-sm ml-3 mr-3" href="{{ route('login') }}">Login</a>
                    <a class="font-bold uppercase text-gray-600 text-sm ml-3 mr-3" href="{{ route('register.index') }}">Crear cuenta</a>
                    @endguest
                </nav>
            </div>
        </header>

        <main class="container mx-auto mt-10">
            <h2 class="font-black text-center text-3xl mb-10">@yield('titulo')</h2>
            @yield('contenido')
        </main>

        <footer class="text-center p-5 text-gray-600 font-bold uppercase mt-10">
            PhootoMania - Todos los derechos reservados {{ now()->year }}
        </footer>
    </body>
</html>
