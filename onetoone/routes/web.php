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

//  One is to One Relationship CRUD
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


//  One is to Many Relationship CRUD
// Creating data 
Route::get('post/create', function () {

    $post = new Post(['title'=>'Make a move', 'body'=> 'song by Incubus']);

    return User::findOrFail(1)->posts()->save($post);

});

//Reading data
Route::get('getPostofUser/{id}', function ($id) {
    
    $user = User::findOrFail($id);

    // dd = dive dump... for debugging.
    dd($user->posts->first());
});

// Updating data
Route::get('update/{id}', function ($id) {

    $user = User::find($id);

    return $user->posts()->whereId($id)->update(['title'=>'I love laravel', 'body'=>'this s body of a post.']);
});

Route::get('delete/{id}', function ($id) {
    
    $user = User::find(1);

    return $user->posts()->whereId($id)->delete();
});
