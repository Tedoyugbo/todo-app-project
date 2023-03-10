<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Components\Admin\Dashboard;
use App\Http\Livewire\Components\Admin\Roles;
use App\Http\Livewire\Components\Admin\Users;
use App\Http\Livewire\Home;
use App\Http\Livewire\Login;
use App\Http\Livewire\Register;
use Illuminate\Support\Facades\Route;

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

// Allow if Not Authenticated
Route::group(['middleware' => 'checkAuth'], function(){
    // Authentication Route : Login
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    // Authentication Route : Register
    Route::get('/register', [RegisterController::class,'register'])->name('register');
});

//Open Routes

//Authenticated Routes
Route::middleware('auth')->group(function (){
    // Home Route
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Profile Route
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});
