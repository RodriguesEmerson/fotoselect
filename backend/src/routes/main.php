<?php

use App\Http\Route;

/**
 * Availables Routes;
 * The first parameter is the Route
 * The second paramenter is the Controller and Method to be called in the Route.
 * Route::method('route', 'Controller@function)
 */
Route::post('/user/login', 'UserController@login');
Route::post('/user/logout', 'UserController@logout');
Route::post('/user/register', 'UserController@register');
Route::get('/user/fetch', 'UserController@fetch');
Route::put('/user/update', 'UserController@update');
Route::delete('/user/delete', 'UserController@delete'); 

Route::post('/galery/create', 'GaleryController@create');
Route::get('/galery/fetch/{id}', 'GaleryController@fetch');
Route::post('/galery/upload', 'GaleryController@upload');
Route::post('/galery/createaccess', 'GaleryController@createAccess');
Route::delete('/galery/deleteaccess', 'GaleryController@deleteAccess');
Route::delete('/galery/delete', 'GaleryController@delete');
Route::delete('/galery/images/delete', 'GaleryController@deleteImage');

Route::post('/client/register', 'ClientController@register');
Route::get('/client/fetch/{id}', 'ClientController@fetch');
Route::get('/client/fetchall', 'ClientController@fetchAll');
Route::put('/client/update', 'ClientController@update');
Route::post('/client/changeimage', 'ClientController@changeImage');
Route::delete('/client/delete', 'ClientController@delete');