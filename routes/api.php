<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/divisions/{id}', function ($id) {
    return json_encode(App\Models\Division::where('country_id', $id)->get());
});

Route::get('/districts/{id}', function ($id) {
    return json_encode(App\Models\District::where('division_id', $id)->get());
});
