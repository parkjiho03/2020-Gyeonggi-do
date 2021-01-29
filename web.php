<?php

use Gondr\App\Route;
use Gondr\App\DB;

Route::get('/', 'MainController@index');
if(!isset($_SESSION['user'])) {
    Route::post('/signUp', 'UserController@signUpProcess');
    Route::post('/signIn', 'UserController@signInProcess');
} else {
    Route::get('/user/housewarming', 'MenuController@housewarming');
    Route::post('/user/housewarming', 'MenuController@housewarmingProcess');
    Route::get('/user/specialist', 'MenuController@specialist');
    Route::post('/user/specialist', 'MenuController@specialistProcess');
    Route::get('/user/review', 'MenuController@review');
    Route::post('/user/review', 'MenuController@reviewProcess');
    Route::post('/user/reviews', 'MenuController@reviewSend');
    Route::post('/user/reviewView', 'MenuController@reviewUpdate');
    Route::get('/logout', 'UserController@logout');
}