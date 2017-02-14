<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('pages/home');
});
//General
Route::get('/{account_type}/register','Auth\RegisterController@index');
Route::get('settings', 'SettingsController@index');
Route::post('settings/update', 'SettingsController@update');
Route::get('search', 'SearchController@index');
Route::get('{account_type}/profile/{id}', 'ProfileController@index');


Route::post('/api/login/post','Auth\LoginController@login_post');

//Patient

//Doctor
Route::post('doctor/register', 'Auth\RegisterController@post_register');
Route::get('schedule', 'doctor\ScheduleController@index');
Route::resource('schedule', 'doctor\ScheduleController');
Route::post('/api/schedule/create/post','doctor\ScheduleController@store');
Route::post('/api/schedule/update/post','doctor\ScheduleController@update');
Route::get('/api/schedules/get/{id}','doctor\ScheduleController@api_schedules_get');
Route::post('/api/schedule/delete/post','doctor\ScheduleController@destroy');


Route::group(['middleware' => ['web'  ]], function () {
	
	Route::auth();

	
	Route::get('/feedback', 'doctor\FeedbackController@index');
	Route::get('/api/feedbacks/get/', 'doctor\FeedbackController@api_feedbacks_get');
	Route::post('/api/feedback/post', 'doctor\FeedbackController@store');
	Route::post('api/feedback/delete/post', 'doctor\FeedbackController@api_feedback_delete_post');
	Route::post('api/feedback/approved/post', 'doctor\FeedbackController@api_feedback_approve_post');
	Route::get('/api/feedback/approved/get/{id}', 'doctor\FeedbackController@api_feedback_approved_get');

	Route::get('/appointment', 'AppointmentController@index');
	Route::post('/api/appointment/request/post ','AppointmentController@api_appointment_request_post');
	Route::get('/api/auth/appointment/get', 'AppointmentController@api_auth_appointment_get');
	Route::get('/api/appointment/delete/post', 'AppointmentController@api_appointment_delete_post');
	Route::get('/api/auth/schedule/appointment/get/{id}', 'AppointmentController@api_auth_schedule_appointment_get');
	Route::post('/api/appointment/confirm/post', 'AppointmentController@api_appointment_confirm_post');
	Route::post('/api/appointment/delete/post', 'AppointmentController@api_appointment_delete_post');
	Route::post('/api/appointment/reschedule/post', 'AppointmentController@api_appointment_reschedule_post');

});


Route::post('medical_facility/register', 'Auth\RegisterController@post_register');

// Authentication routes...
Route::get('login', 'Auth\LoginController@getLogin');
Route::post('login', 'Auth\LoginController@postLogin');
Route::get('logout', 'Auth\LogoutController@getLogout');



Route::get('foo', function(){
	return "foo";
});

Auth::routes();

Route::get('/home', 'HomeController@index');
