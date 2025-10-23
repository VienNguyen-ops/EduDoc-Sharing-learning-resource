<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;

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
    $uploads = App\Models\Upload::all(); // Fetch all uploads from the database
    return view('home', compact('uploads'));
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



Route::resource('uploads', App\Http\Controllers\UploadController::class);
Route::get('uploads/download/{id}', [App\Http\Controllers\UploadController::class, 'download'])
    ->name('uploads.download');
Route::get('/uploads_management', function() {
    $uploads = \App\Models\Upload::with(['user', 'category'])->get();
    return view('uploads_management', compact('uploads'));
})->name('uploads_management');
Route::get('/uploads/{id}/detail', function ($id) {
    return response('<h1>Detail</h1>', 200);
})->name('uploads.detail');
Route::get('/detail/{id}', function ($id) {
    return view('detail');
})->name('detail');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');
Route::post('/profile/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');




