<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginCheck'])->name('login.check');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', function () {
    if (session('role') === 'admin') {
        $userCount = User::count();
        $documentCount = DB::table('uploads')->where('type', 'document')->count();
        $examCount = DB::table('uploads')->where('type', 'exam')->count(); 
        return view('admin_dashboard', [
            'userCount' => $userCount,
            'documentCount' => $documentCount,
            'examCount' => $examCount
        ]);
    }
    return redirect('/login');
})->name('admin.dashboard');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'registerCheck'])->name('register.check');

Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::get('/categories-management', function() {
    $categories = App\Models\Category::all();
    return view('categories_management', compact('categories'));
})->name('categories_management');

Route::resource('user', App\Http\Controllers\UserController::class);
Route::get('/users-management', function() {
    $users = \App\Models\User::with('role')->get();
    return view('users_management', compact('users'));
})->name('users_management');

Route::resource('role', App\Http\Controllers\RoleController::class);
Route::get('/roles-management', function() {
    $roles = \App\Models\Role::all();
    return view('roles_management', compact('roles'));
})->name('roles_management');

Route::resource('documents', App\Http\Controllers\DocumentController::class);
Route::get('/manage', function() {
    $documents = \App\Models\Document::with(['category', 'user'])->get();
    return view('manage', compact('documents'));
})->name('manage');