<?php

use App\Http\Livewire\LikePost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoveController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DislikeController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class )->name('home');

// Rutas de Registro y Autentificación
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// Rutas para el perifl de usuario
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

// Rutas de Posts
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// Ruta de Publicar comentarios
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

// Ruta de subida de imágenes al servidor
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');




Route::prefix('/posts/{post}')->group(function () {
    Route::post('/loves', [LoveController::class, 'store'])->name('posts.loves.store');
    Route::delete('/loves', [LoveController::class, 'destroy'])->name('posts.loves.destroy');

    Route::post('/likes', [LikeController::class, 'store'])->name('posts.likes.store');
    Route::delete('/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

    Route::post('/dislikes', [DislikeController::class, 'store'])->name('posts.dislikes.store');
    Route::delete('/dislikes', [DislikeController::class, 'destroy'])->name('posts.dislikes.destroy');

    Route::post('/reports', [ReportController::class, 'store'])->name('posts.reports.store');
    Route::delete('/reports', [ReportController::class, 'destroy'])->name('posts.reports.destroy');
});





// Ruta con variable que se verifica la última para evitar problemas con las otras rutas
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');


// Siguiendo usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');