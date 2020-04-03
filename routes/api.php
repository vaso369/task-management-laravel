<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::post('/sendMail', 'MailController@sendMail');

Route::group(['prefix' => 'tasks', 'middleware' => 'jwtAuth'], function () {
    Route::post('/', 'TasksController@getAllTasks');
    Route::post('/progress', 'TasksController@getProgressTasks');
    Route::post('/done', 'TasksController@getDoneTasks');
    Route::post('/update', 'TasksController@updateTask');
});

Route::group(['middleware' => 'jwtAuth'], function () {
    Route::post('/editProfile', 'UserController@editProfile');
    Route::resource('/uploadPhoto', 'PhotoController');
    Route::post('/sendMessage', 'MessageController@sendMessage');
});

Route::group(['middleware' => ['jwtAuth', 'jwtRole']], function () {
    Route::post('/addTask', 'TasksController@addTask');
    Route::post('/getTasksBySearch', 'TasksController@getTasksBySearch');
    Route::post('/getYourTeam', 'BossController@getYourTeam');
    Route::post('/getActivities', 'BossController@getUserActivities');

});
