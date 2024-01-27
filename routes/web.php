<?php

use App\Models\listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|   --------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// show all listing
Route::get('/', [ListingController::class,'index']);

// show create form
Route::get('/listing/create', [ListingController::class,'create'])->middleware('auth');

// Manage Listing
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');
//show single listing
Route::get('/listing/{listing}',[ListingController::class,'show']);


// store listing data
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

// Edit listing
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

// update Listing
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

// Delete Listing
Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');

// show register create form
Route::get('/register', [UserController::class,'create'])->middleware('guest');;
// create some user
Route::post('/users',[UserController::class, 'store']);
// User logout
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');;
// Show login form
Route::get('/login',[UserController::class,'login'])->name('login');
// Login user
Route::post('/users/authenticate',[UserController::class,'authenticate'])->middleware('guest');
//common resource routes
//index - show all listings
//show - show single listing
//create - show form to create a new listing
//store - store new listings
//edit - show form to edit listing
//update - update listing
//destroy - Delete listing