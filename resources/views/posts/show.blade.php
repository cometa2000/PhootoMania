@extends('layouts.app')

@section('titulo')
{{ $post->titulo }}
@endsection

@section('contenido')
<div class="container mx-auto md:flex gap-6">
    <div class="md:w-1/2">
        <img src="{{ asset('uploads').'/'.$post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
    </div>
    <div class="md:w-1/2 p-5 shadow-lg md:rounded-lg bg-white">
        
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('posts.index', ['user'=> $user->username]) }}"  >
                    <i class="fa-solid fa-user mr-1"></i>{{ $user->username }}
                </a>
            </div>
            @auth
                <div class="flex space-x-2">
                    @if ($post->checkLove(auth()->user()))
                        <!-- Botón de Unlike -->
                        <form method="POST" action="{{ route('posts.loves.destroy', $post) }}" class="mr-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <i class="fa-solid fa-heart" style="color: #e51515;"></i> <!-- Love lleno -->
                            </button>
                        </form>
                    @else
                        <!-- Botón de Like -->
                        <form method="POST" action="{{ route('posts.loves.store', $post) }}" class="mr-2">
                            @csrf
                            <button type="submit" >
                                <i class="fa-regular fa-heart"></i> <!-- Love vacío -->
                            </button>
                        </form>
                    @endif

                    @if ($post->checkLike(auth()->user()))
                        <form method="POST" action="{{ route('posts.likes.destroy', $post) }}" class="mr-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <i class="fa-solid fa-thumbs-up" style="color: #085ae7;"></i> <!-- Like lleno -->
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('posts.likes.store', $post) }}" class="mr-2">
                            @csrf
                            <button type="submit">
                                <i class="fa-regular fa-thumbs-up"></i> <!-- Like vacío -->
                            </button>
                        </form>
                    @endif

                    @if ($post->checkDislike(auth()->user()))
                        <form method="POST" action="{{ route('posts.dislikes.destroy', $post) }}" class="mr-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <i class="fa-solid fa-thumbs-down" style="color: #005eff;"></i> <!-- DisLike lleno -->
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('posts.dislikes.store', $post) }}" class="mr-2">
                            @csrf
                            <button type="submit">
                                <i class="fa-regular fa-thumbs-down"></i> <!-- DisLike vacío -->
                            </button>
                        </form>
                    @endif

                    @if ($post->checkReport(auth()->user()))
                        <form method="POST" action="{{ route('posts.reports.destroy', $post) }}" class="mr-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mr-5">
                                <i class="fa-solid fa-triangle-exclamation" style="color: #fcba03;"></i> <!-- Report lleno -->
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('posts.reports.store', $post) }}" class="mr-2">
                            @csrf
                            <button type="submit" class="mr-5">
                                <i class="fa-solid fa-triangle-exclamation"></i> <!-- Report vacío -->
                            </button>
                        </form>
                    @endif
                </div>
            @endauth
        </div>
        <div>
            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            <p class="mt-5">{{ $post->descripcion }}</p>

            
        </div>

        @auth
            @if($post->user_id === auth()->user()->id)
                <div>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Eliminar publicación" class="bg-red-500 hover:bg-red-600 p-2 text-sm rounded text-white mt-4 cursor-pointer">
                    </form>
                </div>
            @endif
        @endauth

        <div class="mt-5">
            <p class="text-xl font-bold text-center mb-4">Comentarios</p>
        </div>
        @if(session('mensaje'))
            <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                {{ session('mensaje') }}
            </div>
        @endif
        @guest
            <p class="text-gray-600 uppercase text-sm text-center font-bold">Debes iniciar sesión para poder comentar.</p>
        @endguest
        @auth
            <form action="{{ route('comentarios.store', ['post'=>$post, 'user'=>$user]) }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Escribe un comentario</label>
                    <textarea name="comentario" id="comentario" placeholder="Descripción de la publicación" class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror"></textarea>
                    @error('comentario')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <input type="submit" value="Comentar" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        @endauth
        <div class="shadow rounded-md my-5 max-h-40 overflow-y-scroll">
            @if($comentarios->count())
                @foreach($comentarios as $comentario)
                    <div class="p-2 border-gray-300 border-b">
                        <a href="{{ route('posts.index', ['user'=> $comentario->user]) }}" class="font-bold">{{ $comentario->user->username }}</a>
                        <p>{{ $comentario->comentario }}</p>
                        <p class="text-sm text-gray-500">{{ $comentario->created_at->DiffForHumans() }}</p>
                    </div>
                @endforeach
            @else
                <p class="p-10 text-center text-gray-700">No hay comentarios aún.</p>
            @endif
        </div>
    </div>
</div>
@endsection
    