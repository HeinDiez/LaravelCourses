<?php

namespace App\Models;

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Creating data relation One is to One.
Route::get('insert/{id}', function ($id) {
    $user = User::findOrFail($id);

    $address = new Address(['address'=>'Wolvenlaan, Hilversum']);

    return $user->address()->save($address);
});