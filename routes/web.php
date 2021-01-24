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

use Illuminate\Support\Facades\Route;

Route::get('/', "StaticPagesController@home")->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup', 'UsersController@create')->name('signup');

Route::resource('users', 'UsersController')->names('users');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

// 重置密码
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 微博的删除和创建
Route::resource('statuses', 'StatusesController')->only(['store', 'destroy'])->names('statuses');


// 用户社交统计页面
Route::get("/users/{user}/followings", 'UsersController@followings')->name('users.followings');
Route::get("/users/{user}/followers", 'UsersController@followers')->name('users.followers');


// 测试关联关系
use App\Models\User;
Route::get('/test/{user}', function (User $user) {
    $followers = $user->followers()->get()->toArray();

    $followings = $user->followings();

    // $followings->sync([43], false);
    $followings->detach([42]);
    var_dump($followings->allRelatedIds()->toArray());
});
