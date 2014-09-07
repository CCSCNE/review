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
Route::resource('submission', 'SubmissionCon');
/*
Route::resource('keyword', 'KeywordCon');
Route::resource('conference', 'ConferenceCon');
Route::resource('category', 'CategoryCon');
Route::resource('review', 'ReviewCon');
Route::resource('document', 'DocumentCon');
 */

Route::get('login', 'UserCon@getLogin');
Route::post('login', 'UserCon@postLogin');
Route::get('logout', 'UserCon@getLogout');
Route::get('signup', 'UserCon@getSignup');
Route::post('signup', 'UserCon@postSignup');

Route::get('category/{category}/submission/create/{user?}',
    array('as'=>'category.submission', 'uses'=>'SubmissionCon@create'));

Route::get('category/{category}/volunteer/{user}', 'CategoryCon@getVolunteerToReview');
Route::post('category/{category}/volunteer/{user}', 'CategoryCon@postVolunteerToReview');

Route::get('download/{document}', 'DocumentCon@download');
Route::post('upload', 'DocumentCon@upload');

Route::get('chair/assignments/{category}', 'ChairCon@getAssignments');
Route::post('chair/assignments', 'ChairCon@postAssignments');



Route::get('author', 'AuthorCon@showHome');
Route::get('author/submit/{category}', 'AuthorCon@create');
Route::post('author/submit/{category}', 'AuthorCon@save');
Route::get('author/{submission}', 'AuthorCon@edit');
Route::post('author/{submission}', 'AuthorCon@update');
Route::get('author/delete/document/{document}', 'DocumentCon@confirmDeleteDocument');
Route::post('author/delete/document/{document}', 'DocumentCon@deleteDocument');
Route::post('author/save/keywords/{submission}', 'AuthorCon@saveKeywords');


Route::get('reviewer', 'ReviewerCon@showHome');
Route::get('reviewer/{review}', 'ReviewerCon@viewReview');
Route::get('reviewer/delete/document/{document}', 'DocumentCon@confirmDeleteDocument');
Route::post('reviewer/delete/document/{document}', 'DocumentCon@deleteDocument');
Route::post('reviewer/save/keywords', 'ReviewerCon@saveKeywords');
Route::post('reviewer/save/categories', 'ReviewerCon@saveCategories');


Route::get('chair', 'ChairCon@home');
Route::get('chair/category/{category}', 'ChairCon@viewCategory');
Route::post('chair/category/{category}/keyword/save', 'ChairCon@saveCategoryKeywords');
Route::post('chair/category/{category}/keyword/create', 'ChairCon@createCategoryKeyword');


Route::filter('login', function()
{
    if (Auth::guest())
    {
        return Redirect::guest('login');
    }
});
Route::when('author*', 'login');
Route::when('reviewer*', 'login');
Route::when('chair*', 'login');
