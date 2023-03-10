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
Route::get('address/create/{id}', function ($id) {
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
Route::get('address/get/{id}', function ($id) {
    return User::findOrFail($id)->address;
});

// Deleting  data
Route::get('address/delete/{id}', function ($id) {
    
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
Route::get('post/get/{id}', function ($id) {
    
    $user = User::findOrFail($id);

    // dd = dive dump... for debugging.
    dd($user->posts->first());
});

// Updating data
Route::get('post/update/{id}', function ($id) {

    $user = User::find($id);

    return $user->posts()->whereId($id)->update(['title'=>'I love laravel', 'body'=>'this s body of a post.']);
});

Route::get('post/delete/{id}', function ($id) {
    
    $user = User::find(1);

    return $user->posts()->whereId($id)->delete();
});


//  Many to Many Relationship CRUD

// Creating data 
Route::get('user/create/role/{id}', function ($id) {
    $user = User::findOrFail($id);

    return $user->roles()->save(new Role(['name'=>'Guess']));
});

// Getting User Roles 
Route::get('user/get/role/{id}', function ($id) {

    $user = User::findOrFail($id);

    return $user->roles();
});

// Updating user Roles
Route::get('user/update/role/{id}', function ($id) {
    
    $user = User::findOrFail($id);

    if ($user->has('roles')){

        foreach($user->roles as $role){

            if ($role->name == 'Admin') {

                $role->name = strtolower($role->name);
                $role->save();

            }

        }
    }
});


// Deleting data
Route::get('users/delete/role/{id}', function ($id) {
    $user = User::findOrFail($id);
    
    if ($user->has('roles')){

        foreach($user->roles as $role){

            echo $role->whereId(1)->delete();

        }
    }
});

//Attaching , detaching and syncing
// Attach will add pivot data.
Route::get('users/attach/{id}', function ($id) {
    $user = User::findOrFail($id);

    return $user->roles()->attach(2);

});

// Detach will remove pivot data
Route::get('users/detach/{id}', function ($id) {
    $user = User::findOrFail($id);

    return $user->roles()->detach();

    //detach() will remove all attachment to the data.
});

// Sync will overwrite all pivot data depending on the given data
Route::get('users/sync/{id}', function ($id) {
    $user = User::findOrFail($id);

    return $user->roles()->sync([1]);

});