<?php

use App\Http\Controllers\AppleWalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ============================================
// Apple Wallet Web Service API (spec Apple PassKit)
// ============================================
// These endpoints are called automatically by iOS devices.
// Protected by ValidateWalletToken middleware (verifies Authorization: ApplePass {token})

Route::prefix('v1')->group(function () {

    // Device registration/unregistration
    Route::post(
        'devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}/{serialNumber}',
        [AppleWalletController::class, 'registerDevice']
    )->middleware(\App\Http\Middleware\ValidateWalletToken::class);

    Route::delete(
        'devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}/{serialNumber}',
        [AppleWalletController::class, 'unregisterDevice']
    )->middleware(\App\Http\Middleware\ValidateWalletToken::class);

    // Get serial numbers of updated passes
    Route::get(
        'devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}',
        [AppleWalletController::class, 'getUpdatedSerials']
    );

    // Get latest pass (requires auth token)
    Route::get(
        'passes/{passTypeIdentifier}/{serialNumber}',
        [AppleWalletController::class, 'getLatestPass']
    )->middleware(\App\Http\Middleware\ValidateWalletToken::class);

    // Log endpoint (no auth needed — Apple sends device logs here)
    Route::post('log', [AppleWalletController::class, 'logMessages']);
});
