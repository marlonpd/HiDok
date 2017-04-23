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


//General
Route::get('/', 'HomeController@index');
Route::get('/{account_type}/register','Auth\RegisterController@index');
Route::get('settings', 'SettingsController@index');
Route::post('settings/update', 'SettingsController@update');
Route::get('search', 'SearchController@index');
Route::get('{account_type}/profile/{id}', 'ProfileController@index');
Route::get('about', 'AboutController@index');
Route::get('contact', 'ContactController@index');

Route::post('hospital/register', 'Auth\RegisterController@post_register');
Route::post('laboratory/register', 'Auth\RegisterController@post_register');
Route::post('pharmacy/register', 'Auth\RegisterController@post_register');

Route::post('/api/login/post','Auth\LoginController@login_post');
Route::post('doctor/register', 'Auth\RegisterController@post_register');

Route::get('/api/constants/get', 'PublicController@api_constants_get');

Route::group(['middleware' => ['web'  ]], function () {
	
	Route::auth();

	Route::get('/api/auth/user/get', 'auth\AuthController@api_auth_user_get');

	Route::get('/feedback', 'doctor\FeedbackController@index');
	Route::get('/api/feedbacks/get/', 'doctor\FeedbackController@api_feedbacks_get');
	Route::post('/api/feedback/post', 'doctor\FeedbackController@store');
	Route::post('api/feedback/delete/post', 'doctor\FeedbackController@api_feedback_delete_post');
	Route::post('api/feedback/approved/post', 'doctor\FeedbackController@api_feedback_approve_post');
	Route::get('/api/feedback/approved/get/{id}', 'doctor\FeedbackController@api_feedback_approved_get');

	Route::get('/appointment', 'AppointmentController@index');
	Route::post('/api/appointment/request/post ','AppointmentController@api_appointment_request_post');
	Route::get('/api/auth/appointment/get/{clinic_id}', 'AppointmentController@api_auth_appointment_get');
	Route::get('/api/auth/appointment/patient/get/', 'AppointmentController@api_auth_appointment_patient_get');
	Route::get('/api/auth/appointment/all/get', 'AppointmentController@api_auth_appointment_all_get');
	Route::get('/api/appointment/delete/post', 'AppointmentController@api_appointment_delete_post');
	Route::get('/api/auth/appointment/get/{id}', 'AppointmentController@api_auth_schedule_appointment_get');
	Route::post('/api/appointment/confirm/post', 'AppointmentController@api_appointment_confirm_post');
	Route::post('/api/appointment/consult/post', 'AppointmentController@api_appointment_consult_post');
	Route::post('/api/appointment/delete/post', 'AppointmentController@api_appointment_delete_post');
	Route::post('/api/appointment/reschedule/post', 'AppointmentController@api_appointment_reschedule_post');

	//Route::get('/schedule', 'doctor\ScheduleController@index');

	Route::get('/clinic', 'doctor\ClinicController@index');
	Route::post('/api/clinic/create/post','doctor\ClinicController@store');
	Route::post('/api/clinic/update/post','doctor\ClinicController@update');
	Route::get('/api/clinics/get/{id}','doctor\ClinicController@api_clinics_get');
	Route::post('/api/clinic/delete/post','doctor\ClinicController@destroy');

	//doctor
	Route::get('/patient/itr/{id}','ITRController@patient_itr');
	Route::get('/api/patient/itr/get/{id}', 'ITRController@api_patient_itr_get');
	Route::post('/api/itr/assessment/post', 'ITRController@api_itr_assessment_post');

	Route::post('/api/itr/laboratory/post', 'ITRController@api_itr_laboratory_post');
	Route::post('/api/itr/dx/post', 'ITRController@api_itr_dx_post');
	Route::post('/api/itr/treatment/post', 'ITRController@api_itr_treatment_post');
	Route::get('/print/dx/{id}','ITRController@print_dx');

	//patient 
	Route::get('/itr/{id}','ITRController@patient_itr');

	Route::get('/api/patient/my/get','DoctorPatient@api_patients_my_get');
	Route::get('/api/doctors/my/get','DoctorPatient@api_doctors_my_get');
	Route::post('/api/patient/remove/post','DoctorPatient@api_remove_patient_post');

	Route::post('/api/rate/post', 'RatingsController@api_rate_post');

});


// Authentication routes...
Route::get('login', 'Auth\LoginController@getLogin');
Route::post('login', 'Auth\LoginController@postLogin');
Route::get('logout', 'Auth\LogoutController@getLogout');

//testing
Route::get('/header', 'HomeController@header');

Auth::routes();
Route::get('/home', 'HomeController@index');
