<?php

use App\Http\Controllers\UrlController;
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

Route::get('{url}', array( UrlController::class, 'redirect' ));

Route::apiResource('urls', UrlController::class);

Route::get(
	'/',
	array( UrlController::class, 'index' )
);

// Route::get(
// '/',
// function () {
// return Inertia::render(
// 'Welcome',
// array(
// 'canLogin'       => Route::has( 'login' ),
// 'canRegister'    => Route::has( 'register' ),
// 'laravelVersion' => Application::VERSION,
// 'phpVersion'     => PHP_VERSION,
// )
// );
// }
// );

// Route::middleware( array( 'auth:sanctum', 'verified' ) )->get(
// 	'/dashboard',
// 	function () {
// 		return Inertia::render( 'Dashboard' );
// 	}
// )->name( 'dashboard' );
