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


Route::get('/', array('as'=>'home', function()
{
	return View::make('home');
}));


Route::get('user/login', array('as'=>'login', 'uses'=>'UserCon@getLogin'));
Route::post('user/login', 'UserCon@postLogin');
Route::get('user/logout', array('as'=>'logout', 'uses'=>'UserCon@getLogout'));
Route::get('user/signup', array('as'=>'signup', 'uses'=>'UserCon@getSignup'));
Route::post('user/signup', 'UserCon@postSignup');


Route::get('category/{category}/submission/create',
    array('as'=>'submit', 'uses'=>'SubmissionCon@create'));


Route::get('document/{document}',
    array('as'=>'download', 'uses'=>'DocumentCon@download'));
Route::post('document/upload', array('as'=>'upload', 'uses'=>'DocumentCon@upload'));
Route::get('document/{document}/delete',
    array('as'=>'delete.document', 'uses'=>'DocumentCon@deleteDocument'));


Route::get('author',
    array('as'=>'author', 'uses'=>'AuthorCon@showHome'));
Route::get('author/submit/{category}',
    array('as'=>'submit', 'uses'=>'AuthorCon@create'));
Route::post('author/submit/{category}', 'AuthorCon@save');
Route::get('author/{submission}', 
    array('as'=>'author.view.submission', 'uses'=>'AuthorCon@edit'));
Route::post('author/save/keywords/{submission}',
    array('as'=>'author.save.keywords', 'uses'=>'AuthorCon@saveKeywords'));


Route::get('reviewer',
    array('as'=>'reviewer', 'uses'=>'ReviewerCon@showHome'));
Route::get('reviewer/{review}',
    array('as'=>'view.review', 'uses'=>'ReviewerCon@viewReview'));
Route::post('reviewer/save/keywords',
    array('as'=>'save.reviewer.keywords', 'uses'=>'ReviewerCon@saveKeywords'));
Route::post('reviewer/save/categories',
    array('as'=>'save.reviewer.categories',
        'uses'=>'ReviewerCon@saveCategories'));


Route::get('chair', array('as'=>'chair', 'uses'=>'ChairCon@home'));
Route::get('chair/category/{category}',
    array('as'=>'chair.view.category', 'uses'=>'ChairCon@viewCategory'));
Route::post('chair/category/{category}/keyword/save',
    array('as'=>'save.category.keywords',
        'uses'=>'ChairCon@saveCategoryKeywords'));
Route::post('chair/category/{category}/keyword/create',
    array('as'=>'create.keyword',
        'uses'=>'ChairCon@createCategoryKeyword'));
Route::post('chair/category/{category}/assignment/save',
    array('as'=>'save.assignments', 'uses'=>'ChairCon@postAssignments'));
Route::post('chair/category/{category}/status/save',
    array('as'=>'save.category.status',
        'uses'=>'ChairCon@saveCategoryStatus'));
Route::post('chair/category/{category}/chair/add',
    array('as'=>'add.chair', 'uses'=>'ChairCon@addCategoryChair'));
Route::get('chair/category/{category}/chair/{chair}/remove',
    array('as'=>'remove.chair', 'uses'=>'ChairCon@removeCategoryChair'));


Route::filter('login', function()
{
    if (Auth::guest())
    {
        return Redirect::guest(route('login'));
    }
});
Route::when('author*', 'login');
Route::when('reviewer*', 'login');
Route::when('chair*', 'login');
