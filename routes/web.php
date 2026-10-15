<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AdminController;

// 1. TikTok Web Feed (Saran / For You)
Route::get('/', [FeedController::class, 'forYou'])->name('feed');
Route::get('/feed', [FeedController::class, 'forYou'])->name('feed.index');
Route::get('/feed/saran', [FeedController::class, 'forYou'])->name('feed.saran');
Route::get('/feed/mengikuti', [FeedController::class, 'following'])->name('feed.following');

// 2. Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// 3. TikTok / IG Video Upload & Detail (Unggah)
Route::get('/unggah', [VideoController::class, 'showUploadForm'])->name('video.upload')->middleware('auth');
Route::post('/unggah', [VideoController::class, 'store'])->middleware('auth');
Route::get('/v/{id}', [VideoController::class, 'show'])->name('video.show');
Route::get('/v/{id}/stream', [VideoController::class, 'stream'])->name('video.stream');
Route::get('/v/{id}/edit', [VideoController::class, 'edit'])->name('video.edit')->middleware('auth');
Route::put('/v/{id}', [VideoController::class, 'update'])->name('video.update')->middleware('auth');
Route::delete('/v/{id}', [VideoController::class, 'destroy'])->name('video.destroy')->middleware('auth');

// 4. Social Interaktivitas (Like, Comment, Share, Follow, Bookmark)
Route::post('/v/{id}/like', [InteractionController::class, 'toggleLike'])->name('video.like');
Route::post('/video/{id}/like', [InteractionController::class, 'toggleLike']);
Route::post('/v/{id}/comment', [InteractionController::class, 'addComment'])->name('video.comment');
Route::post('/video/{id}/comment', [InteractionController::class, 'addComment']);
Route::delete('/comment/{id}', [InteractionController::class, 'deleteComment'])->name('comment.delete');
Route::post('/v/{id}/share', [InteractionController::class, 'share'])->name('video.share');
Route::post('/video/{id}/share', [InteractionController::class, 'share']);
Route::post('/u/{id}/follow', [InteractionController::class, 'toggleFollow'])->name('user.follow');
Route::post('/user/{id}/follow', [InteractionController::class, 'toggleFollow']);

// 5. Jelajahi (Explore) & Tagar
Route::get('/jelajahi', [SearchController::class, 'search'])->name('search');
Route::get('/tag/{name}', [SearchController::class, 'showHashtag'])->name('hashtag.show');

// 6. Profil User (Instagram / TikTok Style)
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::post('/profile/edit', [ProfileController::class, 'update'])->middleware('auth');
Route::get('/u/{id}', [ProfileController::class, 'show'])->name('profile.show');

// 7. Sekolah & Admin
Route::get('/sekolah', [SchoolController::class, 'profile'])->name('school.profile');
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');
Route::post('/admin/v/{id}/approve', [AdminController::class, 'toggleApproval'])->name('admin.approve')->middleware('auth');
Route::get('/landing', [App\Http\Controllers\HomeController::class, 'landing'])->name('landing');
