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


// Updating data relation One is to One.
Route::get('address/update/{id}', function ($id) {
    $address = Address::whereUserId($id)->first();

    $address->address = "Hilversum, Netherlands";

    return $address->save();

});


// Reading data
Route::get('get/{id}', function ($id) {
    return User::findOrFail($id)->address;
});

// Deleting  data
Route::get('delete/{id}', function ($id) {
    
    User::findOrFail($id)->address()->delete();

    return "Done";

});