<?php

/*
 *
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('product', 'ProductController');

Route::get('/', function () {
    $json = Storage::disk('local')->get('data.json');
    $json = json_decode($json, true);
    return view('welcome', [
        'data' => $json
    ]);
});

