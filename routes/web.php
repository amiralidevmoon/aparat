<?php

use App\Events\VideoCreated;
use App\Http\Controllers\CategoryVideoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DislikeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\VideoController;
use App\Mail\EmailVerify;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', [IndexController::class, 'index']);

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::resource('videos', VideoController::class)->scoped([
                                                              'video' => 'slug',
                                                          ]);

Route::resource('categories.videos', CategoryVideoController::class)->scoped([
                                                                                 'category' => 'slug',
                                                                                 'video' => 'slug',
                                                                             ]);

Route::post('/videos/{video}/comments', [CommentController::class, 'store'])->name('comments.store');

// manage likes
Route::middleware(['auth'])->group(function () {
    Route::get('{likeable_type}/{likeable_id}/like', [LikeController::class, 'store'])->name('likes.store');
    Route::get('{likeable_type}/{likeable_id}/dislike', [DislikeController::class, 'store'])
        ->name('dislikes.store');
});

Route::get('/dashboard', static function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Test routes
Route::get('/email', static function () {
    Mail::to('ehsanamiri@gmail.com')->send(new EmailVerify(Auth::user()));
});

Route::get('/event', static function () {
    $video = Video::first();
    VideoCreated::dispatch($video);
});
