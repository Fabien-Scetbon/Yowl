<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\LikeController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Routes Auth

Route::post("register", [PassportAuthController::class, 'register']);

Route::post("login", [PassportAuthController::class, 'login']);
Route::get("login", [PassportAuthController::class, 'login'])->name('login');

Route::post("logout", [PassportAuthController::class, 'logout']);

// Routes Users

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'getUsers']);
    Route::get('{id}', [UserController::class, 'getUser']);
    Route::put('{id}', [UserController::class, 'updateUser']);
    Route::delete('{id}', [UserController::class, 'deleteUser']);
});

//Routes Likes

Route::group(['prefix' => 'likes'], function () {
    Route::get('/', [LikeController::class, 'getLikes']);
    Route::get('{user_id}', [LikeController::class, 'getLikeByUser']);
    Route::get('{post_id}', [LikeController::class, 'getLikeByPost']);
    Route::get('{id}', [LikeController::class, 'getLikeById']);
    Route::post('/', [LikeController::class, 'createLike']);
    Route::put('{id}', [LikeController::class, 'updateLike']);
    Route::delete('{id}', [LikeController::class, 'deleteLike']);
});

// Routes Posts

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'getPostsPage']);
    Route::get('/posts', [PostController::class, 'getPosts']);
    Route::get('{id}', [PostController::class, 'getPost']);
    Route::post('/', [PostController::class, 'createPost']);
    Route::put('{id}', [PostController::class, 'updatePost']);
    Route::delete('{id}', [PostController::class, 'deletePost']);
});

// Routes Comments

Route::group(['prefix' => 'comments'], function () {
    Route::get('/', [CommentController::class, 'getComments']);
    Route::get('{id}', [CommentController::class, 'getComment']);
    Route::post('/', [CommentController::class, 'createComment']);
    Route::put('{id}', [CommentController::class, 'updateComment']);
    Route::delete('{id}', [CommentController::class, 'deleteComment']);
});

// Routes Categories

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'getCategories']);
    Route::get('{id}', [CategoryController::class, 'getCategory']);
    Route::post('/', [CategoryController::class, 'createCategory']);
    Route::put('{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('{id}', [CategoryController::class, 'delete']);
});

// Routes CRUD User

Route::group(['middleware' => 'auth:api'], function () {

    // Route::post('/categories', [CategoryController::class, 'createCategory']);



    // Route::group(['middleware' => 'isadmin'], function () {
    // });
});




    /// Route::get('/login/{login}', [PostController::class, 'getPostLogin']);
