<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();


//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login');
Route::post('/login-check', 'Auth\LoginController@login');

Route::get('/logout', 'LogoutController@loggedOut');

Route::get('/register', 'Auth\RegisterController@registerForm');
Route::post('/register-check', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');


//ログイン中のページ
Route::get('/top','PostsController@index');

Route::post('/post','PostsController@post');
Route::post('/post-delete','PostsController@postDelete');
Route::post('/post-update','PostsController@postUpdate');

Route::get('/my-profile','UsersController@myProfile');
Route::post('/profile','UsersController@profile');
Route::post('/profile-update','UsersController@profileUpdate');

Route::get('/search','UsersController@userList');
Route::post('/search-result','UsersController@search');

Route::post('/follow','FollowsController@follow');
Route::post('/follow-out','FollowsController@followOut');

Route::get('/follow-list','FollowsController@followList');
Route::get('/follower-list','FollowsController@followerList');
