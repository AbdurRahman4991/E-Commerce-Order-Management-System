<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\V1\AuthController;
    use App\Http\Controllers\Api\V1\ProductController;
    use App\Http\Controllers\Api\V1\OrderController;
    use App\Http\Controllers\Api\V1\InvoiceController;


    Route::prefix('v1')->group(function () {
        // Auth
        Route::post('/auth/register', [AuthController::class, 'register'])->middleware('throttle:api');
        Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:api');

        Route::middleware('auth:api')->group(function () {
            Route::get('/auth/profile', [AuthController::class, 'profile']);
            Route::post('/auth/logout', [AuthController::class, 'logout']);
            Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        });

        // Route::group(['prefix' => '/products', 'middleware' => ['auth:api']], function () {
        //     Route::get('/', [ProductController::class, 'index']);
        //     Route::post('/', [ProductController::class, 'store']);
        //     Route::get('{product}', [ProductController::class, 'show']);
        //     Route::post('/import', [ProductController::class, 'importCsv']);
        // });

        Route::group([
            'prefix' => '/products',
            'middleware' => ['auth:api', 'throttle:api']
        ], function () {

            Route::get('/', [ProductController::class, 'index']);
            Route::post('/', [ProductController::class, 'store']);
            Route::get('{product}', [ProductController::class, 'show']);
            Route::post('/import', [ProductController::class, 'importCsv']);

        });


        // Route::group(['prefix' =>'/orders','middleware'=>['auth:api']],function () {
        //     Route::get('/', [OrderController::class, 'index']);
        //     Route::post('/', [OrderController::class, 'store']);
        //     Route::get('/{order}', [OrderController::class, 'show']);
        //     Route::patch('/{order}/status/{status}', [OrderController::class, 'updateStatus']);
        //     Route::get('/{id}/invoice', [InvoiceController::class, 'download']);

            
        // });

        Route::group([
            'prefix' =>'/orders',
            'middleware'=>['auth:api', 'throttle:api']
        ], function () {

            Route::get('/', [OrderController::class, 'index']);
            Route::post('/', [OrderController::class, 'store']);
            Route::get('/{order}', [OrderController::class, 'show']);
            Route::patch('/{order}/status/{status}', [OrderController::class, 'updateStatus']);
            Route::get('/{id}/invoice', [InvoiceController::class, 'download']);

        });


        


    });

    

