<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function (){

    Route::get('/dashboard', function(){
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'subscription'], function (){

        Route::get('order',['as' => 'subscription.create', 'uses' => 'PayPalController@create']);

        Route::get('plan-detail', ['as' => 'plan.detail', 'uses' => 'PayPalController@planDetail']);

        Route::get('subscription-success', ['as' => 'subscription.success', 'uses' => 'PayPalController@subscriptionDetail']);

        Route::get('membership', ['as' => 'membership', 'uses' => 'PayPalController@show']);
    });
});