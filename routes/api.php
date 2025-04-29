<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\VerifyController;

use App\Http\Controllers\admin\RoleMasterController;
use App\Http\Controllers\admin\UserRoleController;
use App\Http\Controllers\admin\UserPermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::group(['middleware' => ['guest']], function() {
        Route::post('/login',[LoginController::class, 'index']);
        Route::post('/reg',[LogoutController::class, 'index']);
        Route::post('/logout',[RegisterController::class, 'index']);

        Route::get('/back-to-login', function () {
            $data = [
                'msg' => 'Session Expired, Please Login',
                'data' => [],
                'success' => false,
                'msgType' => 'error',
                'msgTitle' => 'Error!'
            ];
            return response()->json($data, 401);
        })
        ->name('back-to-login')
        ;
    });
    
    Route::group(['middleware' => ['auth:sanctum','user-auth']], function() {
        /*admin*/
        Route::group(['prefix' => 'a','middleware' => 'role:admin'], function () {
            Route::group(['prefix' => 'role-master'], function () {
                Route::get('/',[RoleMasterController::class, 'list']);
                Route::get('/{id}',[RoleMasterController::class, 'get']);
                Route::post('/',[RoleMasterController::class, 'insert']);
                Route::put('/{id}/{name}',[RoleMasterController::class, 'update']);
                Route::delete('/{id}',[RoleMasterController::class, 'delete']);
            });
            Route::group(['prefix' => 'user-role'], function () {
                Route::post('/',[UserRoleController::class, 'insert']);
                Route::delete('/{user_id}/{role_id}',[UserRoleController::class, 'delete']);
            });
            Route::group(['prefix' => 'user-perms'], function () {
                Route::post('/',[UserPermissionController::class, 'insert']);
                Route::delete('/{user_id}/{permsid}',[UserPermissionController::class, 'delete']);
            });
        });
        Route::group(['prefix' => 'c','middleware' => 'role:common_user'], function () {
            Route::get('/get',[VerifyController::class, 'index']);
            Route::post('/save',[VerifyController::class, 'save'])
                ->middleware('permission:create,read,delete')
            ;
        });
        
    });
});
