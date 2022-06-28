<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;


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


// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  


//All Listings
Route::get('/', [ListingController::class, 'index']);
//Show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Destroy listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Show register form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
//store user and login user
Route::post('/users', [UserController::class, 'store'])->middleware('guest');
//Logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
//Show Login user form
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');
//Login user
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->middleware('guest');
//Manage Lisings
Route::get('listings/manage', [ListingController::class, 'manage'])->middleware('auth');
//Single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);



Route::get('/hello', function () {
    return response("<h2>Hello World<h2>")->header('Content-Type', 'text/plain')
        ->header("foo", 'bar');
});

Route::get('/post/{id}', function ($id) {
    return response('Post ' . $id);
})->where('id', '[0-9]+');

Route::get('/search', function (Request $req) {
    return $req->name . " " . $req->city;
});
