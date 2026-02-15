<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BasicController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Admin\MediaController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('password', [AuthController::class, 'updatePassword'])->name('password.update');
// ->middleware('signed');

Route::post('/check-identifier-b', [BasicController::class, 'checkIdentifier']);
Route::post('/send-otp-b', [BasicController::class, 'sendOtp']);

Route::post('/check-identifier', [BasicController::class, 'checkIdentifier2']);
Route::post('/send-otp', [BasicController::class, 'sendOtp2']);
Route::post('/verify-otp', [BasicController::class, 'verifyOtp2']);
Route::post('/setup-password', [BasicController::class, 'setupPassword2']);

Route::post('admin/blogs/upload', [MediaController::class, 'upload'])->name('admin.blogs.upload');
Route::get('/admin/categories/search', [CategoryController::class, 'search'])
    ->name('admin.categories.search');

Route::get('blogs', [BlogController::class, 'index'])->name('api.blogs.index');                  // List posts, filter by category/featured
Route::get('blogs/search', [BlogController::class, 'search'])->name('api.blogs.search');                // Search posts
Route::get('blogs/slugs', [BlogController::class, 'allSlugs'])->name('api.blogs.slugs');                 // All post slugs
Route::get('blogs/{slug}', [BlogController::class, 'show'])->name('api.blogs.show');                  // Single post by slug
Route::get('blogs/{id}/related', [BlogController::class, 'related'])->name('api.blogs.related');              // Related posts by post ID
Route::get('categories/slugs', [BlogController::class, 'allCategorySlugs'])->name('api.categories.slugs');           // All category slugs
Route::get('categories/{slug}/posts', [BlogController::class, 'postsByCategory'])->name('api.categories.posts');           // Posts by category slug

Route::post('/subscriptions/{subscription}/subscribe', [SubscriptionController::class, 'subscribe']);
Route::delete('/subscriptions/{subscription}/unsubscribe', [SubscriptionController::class, 'unsubscribe']);


Route::post('user/profile/update', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
Route::post('admin/profile/update', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
Route::get('/users/search', [AdminUserController::class, 'search'])->name('admin.users.search');
