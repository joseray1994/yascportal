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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();


Route::group(['middleware'=>['auth']], function(){
    //Type User
    Route::get('/types', 'TypeUserController@index');
    Route::get('/types/{UserType_id?}', 'TypeUserController@show');
    Route::post('/types', 'TypeUserController@store');
    Route::post('/types/{UserType_id}', 'TypeUserController@update');
    Route::delete('/types/{UserType_id}', 'TypeUserController@destroy');
    Route::delete('/types/delete/{id}', 'TypeUserController@delete');

    Route::get('/home', 'HomeController@index')->name('home');



  //Assigment Type
Route::get('/assignmenttype/{id}', 'AssignamentTypeController@index');
Route::get('/assignmenttype/{id}/{detailfood_id?}', 'AssignamentTypeController@show');
Route::put('/assignmenttype/{id}/{detailfood_id}', 'AssignamentTypeController@update');
Route::delete('/assignmenttype/{id}/{detailfood_id}', 'AssignamentTypeController@destroy');


    //Display Index Page Vacancies
    Route::get('/vacancies', 'VacancyController@index');
    Route::get('/vacancies/{vacancy_id?}', 'VacancyController@show');
    Route::post('/vacancies', 'VacancyController@store');
    Route::post('/vacancies/{vacancy_id?}', 'VacancyController@update');
    Route::delete('/vacancies/{vacancy_id?}', 'VacancyController@destroy');
    Route::delete('/vacancies/delete/{id}', 'VacancyController@delete');

    //Display Index Page Candidates
   
    Route::get('/candidates/{id}', 'CandidateController@index');
    Route::get('/candidates/{id}/{candidate_id?}', 'CandidateController@show');
    Route::post('/candidates/{id}', 'CandidateController@store');
    Route::post('/candidates/{id}/{candidate_id?}', 'CandidateController@update');
    Route::delete('/candidates/{id}/delete/{candidate_id?}', 'CandidateController@delete');
    Route::delete('/candidates/{id}/{candidate_id?}', 'CandidateController@destroy');
    Route::get('/candidates/{id}/detail/{candidate_id?}', 'CandidateController@detail');

    //Training
    Route::get('/training', 'TrainingController@index');
    Route::post('/training', 'TrainingController@store');
    Route::put('/training/{trainee_id}', 'TrainingController@update');
    Route::delete('/training/{trainee_id}', 'TrainingController@destroy');
    Route::delete('/training/delete/{id}', 'TrainingController@delete');
    Route::post('/training/generateWeekTraining', 'TrainingController@generateEnd_training');
    Route::post('/training/generateWeekCoaching', 'TrainingController@generateEnd_coaching');

    //Settings
    Route::get('/settings', 'SettingsController@index');
    Route::get('/settings/{settings_id?}', 'SettingsController@show');
    Route::post('/settings', 'SettingsController@store');
    Route::post('/settings/{settings_id}', 'SettingsController@update');
    Route::delete('/settings/{settings_id}', 'SettingsController@destroy');
    Route::delete('/settings/delete/{id}', 'SettingsController@delete');

    //Clients
    Route::get('/clients', 'ClientsController@index');
    Route::post('/clients', 'ClientsController@store');
    Route::get('/clients/{client_id}', 'ClientsController@show');
    Route::put('/clients/{client_id}', 'ClientsController@update');
    Route::delete('/clients/{client_id}', 'ClientsController@destroy');
    Route::delete('/clients/delete/{id}', 'ClientsController@delete');
    Route::post('/clients/document/{id}', 'ClientsController@storeDocuments');
    Route::get('/clients/document/show/{id}', 'ClientsController@showDocuments');
    Route::get('/clients/download/{id}', 'ClientsController@download');
    Route::delete('/clients/documents/delete/{id}', 'ClientsController@deleteDocuments');


    //Contacts for Clients
    Route::post('/clients/contacts', 'ClientsController@storeContacts');
    Route::get('/clients/contacts/show/{id}', 'ClientsController@showContacts');
    Route::get('/clients/contacts/edit/{id}', 'ClientsController@editContacts');
    Route::put('/clients/contacts/{id}', 'ClientsController@updateContacts');
    Route::delete('/clients/contacts/destroy/{id}', 'ClientsController@destroyContacts');
    Route::delete('/clients/contacts/delete/{id}', 'ClientsController@deleteContact');

    //User
    Route::get('/users','UserController@index');
    Route::put('/users/{user}', 'UserController@update');
    Route::get('/users/{user}', 'UserController@edit');
    Route::get('/getClients', 'UserController@clients');
    Route::post('/users', 'UserController@store');
    Route::delete('/users/{id}', 'UserController@destroy');
    Route::delete('/users/delete/{id}', 'UserController@delete');
   
    //Schedule weekly
    Route::get('/weekly', 'ScheduleWeeklyController@index');
    Route::get('/weekly/{id?}', 'ScheduleWeeklyController@show');
    Route::post('/extra/{id}', 'ScheduleWeeklyController@store');
    Route::put('/weekly/{id}', 'ScheduleWeeklyController@update');
    Route::delete('/weekly/{id}', 'ScheduleWeeklyController@delete');
    //Schedule daily
    Route::get('/daily', 'ScheduleDailyController@index');
    Route::get('/daily/{id?}', 'ScheduleDailyController@show');
    Route::put('/daily/{id}', 'ScheduleDailyController@update');

    Route::get('/dayoff', 'ScheduleDailyController@data_dayoff');
    Route::get('/break', 'ScheduleDailyController@data_break');
    Route::get('/detail/{id?}', 'ScheduleWeeklyController@detail');
    Route::put('/quit/{id}', 'ScheduleWeeklyController@quit');
    

    //Operators
    Route::get('/operators', 'OperatorsController@index');
    Route::get('/operators/{id}', 'OperatorsController@show');
    Route::post('/operators', 'OperatorsController@store');
    Route::put('/operators/{id}', 'OperatorsController@update');
    Route::delete('/operators/{id}', 'OperatorsController@destroy');
    Route::delete('/operators/delete/{id}', 'OperatorsController@delete');
    
    //SERVICE GENERAL
    Route::post('/generate', 'ServiceGeneralController@generateNick');
    Route::get('/document/show/{id}/{mat}', 'ServiceGeneralController@showDocument');
    Route::post('/document/{id}/{mat}', 'ServiceGeneralController@storeDocument');
    Route::delete('/documents/delete/{id}', 'ServiceGeneralController@deleteDocuments');
    Route::post('/sumtime', 'ServiceGeneralController@SumTime');
    Route::get('/download/{id}/{mat}', 'ServiceGeneralController@download');
    Route::get('/reason', 'ServiceGeneralController@getReason');
    Route::get('/supervisor', 'ServiceGeneralController@getSupervisor');
    
    //PROFILE
    Route::get('/profile', 'ProfileController@index');
    Route::put('/profile', 'ProfileController@update');


    //Reports
    Route::get('/reports/incident', 'ReportsController@incident_report');
    Route::get('/reports/attendance', 'ReportsController@attendance_report');
    Route::get('/reports/focus', 'ReportsController@focus_report');
    Route::get('/reports', 'ReportsController@index');
  

    //Shift
    Route::get('startShift/','shiftController@startShift');
    Route::get('endShift/','shiftController@endShift');

    //INCIDENT REPORT
    Route::get('/incident', 'IncidentReportController@getIncidents');
    Route::get('/incident/{id}', 'IncidentReportController@getResult');
    Route::post('/incident', 'IncidentReportController@store');
    Route::put('/incident', 'IncidentReportController@update');
    Route::delete('/incident', 'IncidentReportController@delete');
    Route::post('/incident/getTable', 'IncidentReportController@getTable');

    //suspended work 
    Route::get('/suspended', 'SuspendedWorkController@index');
    Route::get('/suspended/{UserType_id?}', 'SuspendedWorkController@show');
    Route::post('/suspended', 'SuspendedWorkController@store');
    Route::put('/suspended/{UserType_id}', 'SuspendedWorkController@update');
    Route::delete('/suspended/{UserType_id}', 'SuspendedWorkController@destroy');
    Route::delete('/suspended/delete/{id}', 'SuspendedWorkController@delete');


});






