<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'index']);
Route::get('/post/{id}', [UserController::class, 'single_post_view'])->name('single_post_view');
Route::get('/post/category/{category_id}', [UserController::class, 'filter_by_category'])->name('filter_by_category');
Route::get('/about', [UserController::class, 'about'])->name('about');


Route::group(['middleware' => 'auth'], function () {
    //
    Route::post('/posts/{id}/comment/store', [UserController::class, 'comment_store'])->name('comment_store');
    Route::get('/questions', [UserController::class, 'questions'])->name('questions');
    Route::post('/questions/store', [UserController::class, 'questions_store'])->name('questions_store');
    Route::delete('/questions/{id}/delete', [UserController::class, 'questions_delete'])->name('questions_delete');

    Route::get('/questions/answer/{id}', [UserController::class, 'questions_answer'])->name('questions_answer');
    Route::post('/questions/answer/{id}/store', [UserController::class, 'questions_answer_store'])->name('questions_answer_store');
    Route::delete('/questions/answer/{id}/delete', [UserController::class, 'answer_delete'])->name('answer_delete');
    Route::get('/questions/answer/{id}/like', [UserController::class, 'answer_like'])->name('answer_like');
    Route::get('/questions/answer/{id}/unlike', [UserController::class, 'answer_unlike'])->name('answer_unlike');

    Route::get('/contact', [UserController::class, 'contact'])->name('contact');
    Route::post('/contact_store', [UserController::class, 'contact_store'])->name('contact_store');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/************ Admin Route ************/

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'Index'])->name('login_form');
    Route::post('/login/owner', [AdminController::class, 'Login'])->name('admin.login');
    // Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard')->middleware('admin');
    //Route::post('/logout', [AdminController::class, 'Admin_logout'])->name('admin.logout');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'Admin_logout'])->name('admin.logout');
        Route::resource('/category', CategoryController::class);
        Route::Resource('/post', PostController::class);

        Route::resource('/admin/contact/messages', MessageController::class);
    });
});

/************ Admin Route end ************/

require __DIR__ . '/auth.php';
