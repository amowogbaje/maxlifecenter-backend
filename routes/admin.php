<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\MessageLogController;
use App\Http\Controllers\Admin\MessagesContactController;
use App\Http\Controllers\Admin\MessageSentController;
use Illuminate\Support\Facades\Route;

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('guest.admin')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle');
});

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('users/fetch', [MessagesContactController::class, 'fetchUsers'])->name('users.fetch');
    Route::get('users/fetch-all', [MessagesContactController::class, 'fetchAll'])->name('users.fetch.all');
    Route::get('users/fetch-meta', [MessagesContactController::class, 'meta'])->name('users.fetch.meta');


    // 📊 Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/analytics', [DashboardController::class, 'analytics'])
        ->name('analytics');

    Route::get('/logs/all', [MessageLogController::class, 'activityLogs'])
        ->name('logs.all')->middleware('can:view activity logs');

    Route::get('/activity-log/{id}/show', [MessageLogController::class, 'showActivityLog'])
        ->name('logs.show')->middleware('can:view logs');



    Route::get('/purchases', [DashboardController::class, 'purchases'])
        ->name('purchases')->middleware('can:view purchases');

    Route::get('/purchases/{id}', [DashboardController::class, 'showPurchase'])
        ->name('purchases.show')->middleware('can:view purchases');

    Route::get('/rewards', [DashboardController::class, 'rewards'])
        ->name('rewards')->middleware('can:view rewards');

    Route::get('/uploads', [DashboardController::class, 'uploads'])
        ->name('uploads')->middleware('can:manage uploads');

    Route::get('/upload-requests', [DashboardController::class, 'uploadRequests'])
        ->name('upload-requests')->middleware('can:manage uploads');

    Route::get('/users', [DashboardController::class, 'users'])
        ->name('users')->middleware('can:view users');

    Route::get('/users/{id}', [DashboardController::class, 'showUser'])
        ->name('users.show')->middleware('can:view users');


    Route::prefix('updates')->name('updates.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index')->middleware('can:view updates');
        Route::get('/create', [BlogController::class, 'create'])->name('create')->middleware('can:create updates');
        Route::post('/store', [BlogController::class, 'store'])->name('store')->middleware('can:create updates');
        Route::get('/{update}', [BlogController::class, 'edit'])->name('edit')->middleware('can:create updates');
        Route::put('/{update}', [BlogController::class, 'update'])->name('update')->middleware('can:create updates');
    });

    Route::get('/profile', [DashboardController::class, 'profile'])
        ->name('profile');

    Route::get('/settings', [DashboardController::class, 'settings'])
        ->name('settings')->middleware('can:manage settings');

    // 👥 Admin list management
    Route::prefix('list')->name('list.')->group(function () {
        Route::get('/', [RoleController::class, 'adminList'])
            ->name('index')->middleware('can:view admins');

        Route::get('/show/{id}', [RoleController::class, 'showAdmin'])
            ->name('show')->middleware('can:view admins');

        Route::post('/store', [RoleController::class, 'storeAdmin'])
            ->name('store')->middleware('can:create admins');
    });

    // 🧩 Roles management
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])
            ->name('index')->middleware('can:view roles');

        Route::post('/', [RoleController::class, 'store'])
            ->name('store')->middleware('can:create roles');

        Route::put('/{id}', [RoleController::class, 'update'])
            ->name('update')->middleware('can:edit roles');
    });

    // 💬 Messages and templates
    Route::prefix('messages')->name('messages.')->group(function () {

        Route::get('/', [MessagesController::class, 'index'])
            ->name('index')->middleware('can:view messages');

        Route::prefix('templates')->name('templates.')->group(function () {
            Route::get('/', [MessagesController::class, 'templates'])
                ->name('index')->middleware('can:view messages');

            Route::get('/create', [MessagesController::class, 'create'])
                ->name('create')->middleware('can:create messages');

            Route::post('/store', [MessagesController::class, 'store'])
                ->name('store')->middleware('can:create messages');

            Route::get('/count', [MessagesController::class, 'countRecipients'])
                ->name('count')->middleware('can:view messages');

            Route::get('/{message}/preview', [MessagesController::class, 'preview'])
                ->name('preview')->middleware('can:view messages');

            Route::post('/{message}/send', [MessagesController::class, 'send'])
                ->name('send')->middleware('can:send messages');

            Route::post('/{message}/test', [MessagesController::class, 'test'])
                ->name('test')->middleware('can:send messages');
        });

        // 🗂 Message logs
        Route::prefix('logs')->name('logs.')->group(function () {
            Route::get('/', [MessageLogController::class, 'index'])
                ->name('index')->middleware('can:view logs');
            Route::get('/{message}/show', [MessageLogController::class, 'show'])
                ->name('show')->middleware('can:view logs');
        });

        // 📤 Sent messages
        Route::prefix('sent')->name('sent.')->group(function () {
            Route::get('/', [MessageSentController::class, 'index'])
                ->name('index')->middleware('can:view messages');
            Route::get('/{message}/show', [MessageSentController::class, 'show'])
                ->name('show')->middleware('can:view messages');
        });

        // 👥 Message contacts
        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', [MessagesContactController::class, 'contacts'])
                ->name('index')->middleware('can:manage contacts');
            Route::get('/create', [MessagesContactController::class, 'create'])
                ->name('create')->middleware('can:manage contacts');
            Route::post('/store', [MessagesContactController::class, 'store'])
                ->name('store')->middleware('can:manage contacts');
            Route::get('/{contactId}', [MessagesContactController::class, 'edit'])
                ->name('edit')->middleware('can:manage contacts');
            Route::put('/{contactId}/update', [MessagesContactController::class, 'update'])
                ->name('update')->middleware('can:manage contacts');
        });
    });
});
