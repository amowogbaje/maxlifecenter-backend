<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\MessageLogController;
use App\Http\Controllers\Admin\MessagesContactController;
use App\Http\Controllers\Admin\MessageSentController;
use Illuminate\Support\Facades\Route;

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('guest:admin')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle');
});

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/activity-log/{id}/show', [MessageLogController::class, 'showActivityLog'])->name('show-activity-log');
    Route::get('/purchases', [DashboardController::class, 'purchases'])->name('purchases');
    Route::get('/purchases/{id}', [DashboardController::class, 'showPurchase'])->name('purchases.show');
    Route::get('/rewards', [DashboardController::class, 'rewards'])->name('rewards');
    Route::get('/uploads', [DashboardController::class, 'uploads'])->name('uploads');
    Route::get('/upload-requests', [DashboardController::class, 'uploadRequests'])->name('upload-requests');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/roles', [DashboardController::class, 'roles'])->name('roles');
    Route::get('/users/{id}', [DashboardController::class, 'showUser'])->name('users.show');
    Route::get('/updates', [DashboardController::class, 'updates'])->name('updates');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessagesController::class, 'index'])->name('index');
        
        Route::prefix('templates')->name('templates.')->group(function () {
            Route::get('/', [MessagesController::class, 'templates'])->name('index');
            Route::get('/create', [MessagesController::class, 'create'])->name('create');
            Route::post('/store', [MessagesController::class, 'store'])->name('store');
            Route::get('/count', [MessagesController::class, 'countRecipients'])->name('count');
            Route::get('/{message}/preview', [MessagesController::class, 'preview'])->name('preview');
            Route::get('/{message}/preview-old', [MessagesController::class, 'previewOld'])->name('preview-old');
            Route::post('/{message}/send', [MessagesController::class, 'send'])->name('send');
            Route::post('/{message}/send-old', [MessagesController::class, 'sendOld'])->name('send-old');
            Route::post('/{message}/test', [MessagesController::class, 'test'])->name('test');
        });

        Route::prefix('logs')->name('logs.')->group(function () {
            Route::get('/', [MessageLogController::class, 'index'])->name('index');
            Route::get('/{message}/show', [MessageLogController::class, 'show'])->name('show');
        });
        Route::prefix('sent')->name('sent.')->group(function () {
            Route::get('/', [MessageSentController::class, 'index'])->name('index');
            Route::get('/{message}/show', [MessageSentController::class, 'show'])->name('show');
        });

        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', [MessagesContactController::class, 'contacts'])->name('index');
            Route::get('/create', [MessagesContactController::class, 'create'])->name('create');
            Route::post('/store', [MessagesContactController::class, 'store'])->name('store');
            Route::get('/{contactId}/preview', [MessagesContactController::class, 'preview'])->name('preview');
            Route::get('/{contactId}/show', [MessagesContactController::class, 'show'])->name('show');

            Route::get('/{contactId}/edit', [MessagesContactController::class, 'edit'])->name('edit');
            Route::put('/{contactId}/update', [MessagesContactController::class, 'update'])->name('update');
            
            Route::post('/{contactId}/send', [MessagesContactController::class, 'send'])->name('send');
            Route::post('/{contactId}/test', [MessagesContactController::class, 'test'])->name('test');
        });
    });
});
