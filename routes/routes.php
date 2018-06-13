<?php
/**
 * Your application routes go here.
 */
use Legato\Framework\Routing\Route;

Route::get('/', 'App\Controllers\IndexController@show');

Route::get('/register', 'App\Controllers\AuthController@showSignUpForm', 'register_form');
Route::post('/register', 'App\Controllers\AuthController@signup', 'register');

Route::get('/login', 'App\Controllers\AuthController@showLoginForm', 'login_form');
Route::post('/login', 'App\Controllers\AuthController@login', 'login');

Route::get('/auth/activation/[*:code]', 'App\Controllers\AuthController@activate', 'activation_code');

Route::get('/logout', 'App\Controllers\AuthController@logout', 'logout');

Route::get('/links', function (){
    return view('links/index');
}, 'link_index');
