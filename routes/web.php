<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\EmailController;

require __DIR__.'/auth.php';

//USUARIO LOGADO
Route::group(['middleware' => 'auth'], function () {
    // Route::post('/logout', [UserController::class, 'logout'])->name('logout');//sair da conta
    Route::post('/like', [PostsController::class, 'like']);//dar like
    Route::post('/comment', [PostsController::class, 'comment']);//dar like
    Route::post('/follow-user', [UserController::class, 'follow_user']);//dar like
    Route::post('/post', [PostsController::class, 'post']);//publicar

    Route::get('/edit', [NavigationController::class, 'edit']);//view editar
    Route::post('/edit-info', [UserController::class, 'editInfo']);//editar informações pessoais
    Route::post('/edit-email', [UserController::class, 'editEmail']);//editar email
    Route::post('/edit-password', [UserController::class, 'editPassword']);//editar senha

    Route::post('/delete-post', [PostsController::class, 'delete']);//apagar post
    Route::post('/edit-post', [PostsController::class, 'edit']);//editar post
    Route::post('/edit-image-account', [UserController::class, 'edit_image']);//editar post


    Route::post('/delete-comment', [PostsController::class, 'delete_comment']);//apagar comentario

    Route::get('/notification', [NotificationController::class, 'notification']);// VIEW das notificações
    Route::get('/set-notification', [NotificationController::class, 'setNotification']);//editar post
    Route::post('/open-notification', [NotificationController::class, 'opeNotification']);//ABRIR NOTIFICAÇÃO

    // Route::get('/chat/{user_name}', [ChatController::class, 'opeChats']);//chats
    Route::get('/chat/{id}', [ChatController::class, 'newChat'])->name('chat.new');//chats
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');//chats
    Route::post('/send-message-chat', [ChatController::class, 'sendMessage']);//chats
});


//USUARIO NÃO LOGADO (utilizando laravel/ui para login)
// Route::group(['middleware' => 'guest'], function () {
    // Login
    // Route::get('/login', [NavigationController::class, 'login'])->name('login');
    // Route::post('/login', [UserController::class, 'login']);

    // // Criar conta
    // Route::get('/register', [NavigationController::class, "register"])->name("register");
    // Route::post('/register', [UserController::class, "store"]);

// });


Route::get('/', [PostsController::class, 'feed'])->name('feed');//feed

Route::get('/sobre', [NavigationController::class, 'about'])->name('about');//feed
Route::get('/search', [UserController::class, "search"])->name("search");
Route::get('/post/{post_id}', [PostsController::class, "view_post"])->name("view_post");
Route::get('/search-username/{username}', [UserController::class, 'searchByUsername']);

Route::get('/send-email', [EmailController::class, "senEmails"])->name('email.send');
Route::get('/{user_name}', [UserController::class, "account"])->name("account");

Route::get('/api/messages/{chat_id}', [ApiController::class, "messagesByChatId"]);

