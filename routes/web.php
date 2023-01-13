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

Route::get('/', 'HomeController@index');

Auth::routes(['register' => false, 'verify' => false]);

Route::resource('professionalbodies', 'ProfessionalBodiesController');
Route::get('/professionalbodies/status/{id}', 'ProfessionalBodiesController@status');

Route::resource('versions', 'VersionsController');
Route::get('/versions/status/{id}', 'VersionsController@status');

Route::resource('courses', 'CoursesController');
Route::get('/courses/status/{id}', 'CoursesController@status');

Route::get('/courses/unit/{id}', 'CourseUnitsController@addnewunit');
Route::put('/courses/unit/{id}', 'CourseUnitsController@createnewunit');
Route::get('/courses/unit/{id}/destroy', 'CourseUnitsController@destroy');
Route::get('/courses/unit/{cid}/{uid}', 'CourseUnitsController@addunit');
Route::get('/courses/units/{id}/edit', 'CourseUnitsController@edit');
Route::post('/coursesunits', 'CourseUnitsController@update');

Route::resource('units', 'UnitsController');
Route::get('/units/status/{id}', 'UnitsController@status');

Route::get('/assignments/{id}/create', 'AssignmentsController@create');
Route::put('/assignments/{id}', 'AssignmentsController@store');
Route::get('/assignments/{id}', 'AssignmentsController@show');
Route::get('/assignments/units/{id}/edit', 'AssignmentsController@unitedit');
Route::get('/assignments/{id}/edit', 'AssignmentsController@edit');
Route::put('/assignments/{id}/update', 'AssignmentsController@update');
Route::post('/assignments/update', 'AssignmentsController@orderupdate');
Route::get('/assignments/{id}/destroy', 'AssignmentsController@destroy');

Route::get('/assignment/resources/{id}/create', 'AssignmentResourcesController@create');
Route::get('/assignment/resources/{id}/edit', 'AssignmentResourcesController@edit');
Route::put('/assignment/resources/{id}', 'AssignmentResourcesController@store');
Route::post('/assignment/resources/update', 'AssignmentResourcesController@update');
Route::get('/assignment/resources/{id}/destroy', 'AssignmentResourcesController@destroy');
Route::get('/assignment/resources/{aid}/{rid}', 'AssignmentResourcesController@createrelationship');

Route::get('/assignment/helpsheets/{id}/create', 'AssignmentHelpsheetsController@create');
Route::get('/assignment/helpsheets/{id}/edit', 'AssignmentHelpsheetsController@edit');
Route::put('/assignment/helpsheets/{id}', 'AssignmentHelpsheetsController@store');
Route::post('/assignment/helpsheets/update', 'AssignmentHelpsheetsController@update');
Route::get('/assignment/helpsheets/{id}/destroy', 'AssignmentHelpsheetsController@destroy');
Route::get('/assignment/helpsheets/{aid}/{hid}', 'AssignmentHelpsheetsController@createrelationship');

Route::get('users/changepassword', 'ChangePasswordController@index');
Route::post('users/changepassword', 'ChangePasswordController@store');

Route::get('/users/create', 'UsersController@create');
Route::post('/users', 'UsersController@store');
Route::get('/users', 'UsersController@index');
Route::post('/users/search/{id}', 'UsersController@search');
Route::get('/users/{id}', 'UsersController@show');
Route::put('/users/assignments/{aid}/{uid}', 'UserAssignmentsController@store');
Route::put('/users/assignments/{id}', 'UserAssignmentsController@update');
Route::get('/users/{id}/edit', 'UsersController@edit');
Route::put('/users/{id}', 'UsersController@update');
Route::get('/users/removecourse/{id}', 'UsersController@removecourse');
Route::get('/users/status/{id}', 'UsersController@status');

Route::get('/resources', 'ResourcesController@index');
Route::get('/resources/create', 'ResourcesController@create');
Route::post('/resources', 'ResourcesController@store');
Route::get('/resources/{id}', 'ResourcesController@show');
Route::get('/resources/status/{id}', 'ResourcesController@status');
Route::get('/resources/{id}/edit', 'ResourcesController@edit');
Route::put('/resources/{id}', 'ResourcesController@update');

Route::get('/helpsheets', 'HelpsheetsController@index');
Route::get('/helpsheets/create', 'HelpsheetsController@create');
Route::post('/helpsheets', 'HelpsheetsController@store');
Route::get('/helpsheets/{id}', 'HelpsheetsController@show');
Route::get('/helpsheets/status/{id}', 'HelpsheetsController@status');
Route::get('/helpsheets/{id}/edit', 'HelpsheetsController@edit');
Route::put('/helpsheets/{id}', 'HelpsheetsController@update');

Route::get('/contactus', 'ContactUsController@usercontact');
Route::post('/contactus', 'ContactUsController@usercontactsend');