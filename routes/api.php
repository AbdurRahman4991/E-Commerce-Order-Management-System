<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\V1\AuthController;
    use App\Http\Controllers\Api\V1\ProductController;


    Route::prefix('v1')->group(function () {
        // Auth
        Route::post('/auth/register', [AuthController::class, 'register']);
        Route::post('/auth/login', [AuthController::class, 'login']);

        Route::middleware('auth:api')->group(function () {
            Route::get('/auth/profile', [AuthController::class, 'profile']);
            Route::post('/auth/logout', [AuthController::class, 'logout']);
            Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        });

        Route::group(['prefix' => '/products', 'middleware' => ['auth:api']], function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/', [ProductController::class, 'store']);
            Route::get('{product}', [ProductController::class, 'show']);
        });

    });

    

