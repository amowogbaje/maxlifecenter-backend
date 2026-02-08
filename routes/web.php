<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailPreviewController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;

Route::get('/migrate', function () {
    Artisan::call('migrate', ['--force' => true]);

    return response()->json([
        'message' => 'Migrations have been run successfully.',
        'output'  => Artisan::output(),
    ]);
});

Route::get('/seed', function () {
    // ✅ Correct seeder option
    Artisan::call('db:seed', ['--class' => 'AdminSeeder']);

    return response()->json([
        'message' => 'Database seeding completed successfully.',
        'output'  => Artisan::output(),
    ]);
});



Route::get('/artisan-command/{signature}', function ($signature) {
    // ❌ Restricted commands for safety
    $restricted = ['down', 'up', 'serve'];

    if (in_array($signature, $restricted)) {
        return response()->json([
            'error' => "The '{$signature}' command is restricted.",
        ], 403);
    }

    try {
        Artisan::call($signature);

        return response()->json([
            'message' => "Artisan command '{$signature}' executed successfully.",
            'output'  => Artisan::output(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
});





// require __DIR__.'/auth.php';

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('welcome.home');

    Route::prefix('emails')->name('emails.')->group(function () {
        Route::get('/', [EmailPreviewController::class, 'index']);
        Route::get('/password', [EmailPreviewController::class, 'password'])->name('password');
        Route::get('/unlocked', [EmailPreviewController::class, 'unlocked'])->name('unlocked');
        Route::get('/reminder', [EmailPreviewController::class, 'reminder'])->name('reminder');
        Route::get('/approved', [EmailPreviewController::class, 'approved'])->name('approved');
        // Route::get('/weekly-report', [EmailPreviewController::class, 'weeklyReport']);
    });
});