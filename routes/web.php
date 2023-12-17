<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// use Illuminate\Support\Facades\Auth;

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
//*************************************************************************************************************
// це буде потрібно для auth-ентифікації через AD
// Route::get('/', [App\Http\Controllers\Ejournal\OrdersController::class,'welcome'])->middleware(['auth']);
// Auth::routes([
//    'reset' => false,
//    'verify' => false,
//    'register' => false,
//   ]);
//Route::get('welcome', [App\Http\Controllers\Ejournal\OrdersController::class,'welcome']);
//*************************************************************************************************************
Route::get('/', [App\Http\Controllers\Ejournal\OrdersController::class, 'welcome']);
Route::get('login', [App\Http\Controllers\Ejournal\OrdersController::class, 'welcome']);
Route::resource('orders', App\Http\Controllers\Ejournal\OrdersController::class)->only(['index', 'store']);
Route::get('orders/precreate', [App\Http\Controllers\Ejournal\OrdersController::class, 'preCreate']);
Route::get('orders/createOrder', [App\Http\Controllers\Ejournal\Edit\CreateOrder::class, 'createOrder']);
Route::get('orders/{order}/clone', [App\Http\Controllers\Ejournal\OrdersController::class, 'clone']);
Route::post('orders/{order}/editPart1', [App\Http\Controllers\Ejournal\OrdersController::class, 'editPart1']);
Route::post('orders/{order}/editPart2', [App\Http\Controllers\Ejournal\OrdersController::class, 'editPart2']);
Route::post('orders/{order}/editPart3', [App\Http\Controllers\Ejournal\OrdersController::class, 'editPart3']);
Route::post('orders/{order}/editPart4', [App\Http\Controllers\Ejournal\OrdersController::class, 'editPart4']);
Route::post('orders/{order}/editPart5', [App\Http\Controllers\Ejournal\OrdersController::class, 'editPart5']);
Route::post('orders/{order}/reEditPart1', [App\Http\Controllers\Ejournal\Edit\ReEditPart1::class, 'reEditPart1']);
Route::post('orders/{order}/reEditPart2', [App\Http\Controllers\Ejournal\Edit\ReEditPart2::class, 'reEditPart2']);
Route::post('orders/{order}/reEditPart3', [App\Http\Controllers\Ejournal\Edit\ReEditPart3::class, 'reEditPart3']);
Route::post('orders/{order}/reEditPart4', [App\Http\Controllers\Ejournal\Edit\ReEditPart4::class, 'reEditPart4']);
Route::get('orders/{order}/pdf', [App\Http\Controllers\Ejournal\PdfGenerateController::class, 'pdf']);

Route::prefix('dicts')->group(function () {
    Route::resource('/Branches', App\Http\Controllers\Ejournal\Dicts\DictBranchesController::class)->only(['index', 'edit', 'create', 'store', 'update']);
    Route::resource('/Units', App\Http\Controllers\Ejournal\Dicts\DictUnitsController::class)->only(['index', 'edit', 'create', 'store', 'update']);
    Route::resource('/Wardens', App\Http\Controllers\Ejournal\Dicts\DictWardensController::class)->only(['index', 'edit', 'create', 'store', 'update']);
    Route::resource('/Adjusters', App\Http\Controllers\Ejournal\Dicts\DictAdjustersController::class)->only(['index', 'edit', 'create', 'store', 'update']);
    Route::resource('/BrigadeMembers', App\Http\Controllers\Ejournal\Dicts\DictBrigadeMembersController::class)->only(['index', 'edit', 'create', 'store', 'update']);
    Route::resource('/BrigadeEngineers', App\Http\Controllers\Ejournal\Dicts\DictBrigadeEngineersController::class)->only(['index', 'edit', 'create', 'store', 'update']);
    Route::resource('/Substations', App\Http\Controllers\Ejournal\Dicts\DictSubstationsController::class)->only(['index', 'edit', 'create', 'store', 'update',]);
    Route::resource('/Lines', App\Http\Controllers\Ejournal\Dicts\DictLinesController::class)->only(['index', 'edit', 'create', 'store', 'update']);
    Route::resource('/Tasks', App\Http\Controllers\Ejournal\Dicts\DictTypicalTasksBaseController::class)->only(['index', 'edit', 'create', 'store', 'update']);
});

Route::get('/clearCache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    return "Кеш очищено.";
});
