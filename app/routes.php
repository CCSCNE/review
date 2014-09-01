<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('home');
});

Route::resource('user', 'UserCon');
Route::resource('keyword', 'KeywordCon');
Route::resource('submission', 'SubmissionCon');
Route::get('category/{category}/submission/create/{user?}',
    array('as'=>'category.submission', 'uses'=>'SubmissionCon@create'));
Route::resource('conference', 'ConferenceCon');
Route::resource('category', 'CategoryCon');
Route::resource('review', 'ReviewCon');
Route::resource('document', 'DocumentCon');

Route::get('login', 'UserCon@getLogin');
Route::post('login', 'UserCon@postLogin');
Route::get('logout', 'UserCon@getLogout');
Route::get('signup', 'UserCon@getSignup');
Route::post('signup', 'UserCon@postSignup');

Route::get('category/{category}/volunteer/{user}', 'CategoryCon@getVolunteerToReview');
Route::post('category/{category}/volunteer/{user}', 'CategoryCon@postVolunteerToReview');

Route::get('download/{document}', 'DocumentCon@download');
