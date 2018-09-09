<?php

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//
Route::get('/', 'PostController@index')->name('index');
Route::post('/post/search', 'PostController@search')->name('search');

// Route vers formulaire de creation d'article
Route::get('/post/create', 'PostController@create')->name('toto99')->middleware('auth');
// Recuperation et envoi vers DB
Route::post('/post/create', 
	[ 'as'=>'create','uses'=>'PostController@store'])->middleware('auth');
//
Route::get('/post/delete/{id}',
	[ 'as'=>'delete','uses'=>'PostController@destroy'])->middleware('auth');

// Route vers formulaire d'update d'article
Route::get('/post/update/{id}',
	[ 'as'=>'toto3','uses'=>'PostController@edit'])->middleware('auth');
Route::post('/post/update/{id}', 
	[ 'as'=>'update','uses'=>'PostController@update'])->middleware('auth');

// Route vers formulaire de creation de commentaires
Route::get('/post/show/{id}', 'PostController@show')
->name('create-comment')
->middleware('auth');

Route::post('/comment/create/{id}', 
	[ 'as'=>'comment','uses'=>'CommentController@store'])
->middleware('auth');
