@extends('layouts.app')


@section('titulo')
Perfil de {{ $user->username }}
@endsection


@section('contenido')
<div class="flex justify-center">
    <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
        <div class="w-8/12 lg:w-6/18 px-5">
            <img class="rounded-full" src="{{ $user->imagen ? asset('perfiles/'.$user->imagen) : asset('img/usuario.svg') }}" alt="">
        </div>
        <div class="w-8/12 lg:w-6/18 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">
            <div class="flex items-center gap-2  mb-5">
                <p class="text-gray-700 text-2xl">{{ $user->username }}</p>
                @auth
                    @if($user->id === auth()->user()->id)
                        <a href="{{ route('perfil.index') }}" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                @endauth
            </div>
            
            <p class="text-gray-800 text-sm mb-3 font-bold">
                {{ $user->followers->count() }}
                <span class="font-normal"> @choice('Seguidor|Seguidores', $user->followers->count() ) </span>
            </p>
            <p class="text-gray-800 text-sm mb-3 font-bold">
                {{ $user->followings->count() }}
                <span class="font-normal">Siguiendo</span>
            </p>
            <p class="text-gray-800 text-sm mb-3 font-bold">
                {{ $user->posts->count() }}
                <span class="font-normal">Posts</span>
            </p>

            @auth
                @if ($user->id == auth()->user()->id)
                    <p class="text-gray-800 text-sm mb-3 font-bold">
                        {{ $user->commentsCount() }}
                        <span class="font-normal">Comentarios</span>
                    </p>
                    <p class="text-gray-800 text-sm mb-3 font-bold">
                        {{ $user->likesCount() }}
                        <span class="font-normal">Likes</span>
                    </p>
                @endif  
            @endauth
            @auth
                @if ($user->id !== auth()->user()->id)
                    @if( !$user->siguiendo( auth()->user() ))
                        <form method="POST" action="{{ route('users.follow', $user) }}">
                            @csrf
                            <input type="submit" class="bg-blue-600 hover:bg-blue-800 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer" value="Seguir">
                        </form>
                    @else
                        <form method="POST" action="{{ route('users.unfollow', $user) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="bg-red-600 hover:bg-red-800 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer" value="Dejar de seguir">
                        </form>
                    @endif
                @endif  
            @endauth
            @auth
                @if ($user->id == auth()->user()->id)
                    <input type="button" class="bg-lime-600 hover:bg-lime-800 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer mt-3" value="Grafica" id="showChartButton">
                    <canvas id="myChart" style="display: none;"></canvas>
                @endif  
            @endauth
        </div>
    </div>
</div>

<section class="container mx-auto mt-10">
    <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
    <x-listar-post :posts="$posts" />
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showChartButton = document.getElementById('showChartButton');
        const myChartCanvas = document.getElementById('myChart');
        
        let data = {
            labels: ['Seguidores', 'Siguiendo', 'Posts', 'Comentarios', 'Likes'],
            datasets: [{
                data: [{{ $user->followers->count() }}, {{ $user->followings->count() }}, {{ $user->posts->count() }}, {{ $user->commentsCount() }}, {{ $user->likesCount() }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',  // Color para Seguidores
                    'rgba(54, 162, 235, 0.2)',  // Color para Siguiendo
                    'rgba(255, 206, 86, 0.2)',  // Color para Posts
                    'rgba(75, 192, 192, 0.2)',  // Color para Comentarios
                    'rgba(153, 102, 255, 0.2)', // Color para Likes
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1,
            }],
        };
    
        const myChart = new Chart(myChartCanvas.getContext('2d'), {
            type: 'pie',
            data: data,
        });
    
        let chartVisible = false;
    
        showChartButton.addEventListener('click', function () {
            if (chartVisible) {
                myChartCanvas.style.display = 'none';
            } else {
                myChart.update();
                myChartCanvas.style.display = 'block';
            }
    
            chartVisible = !chartVisible;
        });
    });
</script>
    

@endsection
