<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', function () {
    return 'Read readme.md';
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    // Matches "/api/register
    $router->post('register', 'AuthController@register');
    // Matches "/api/login
    $router->post('login', 'AuthController@login');
    // Matches "/api/remind
    $router->post('remind', 'AuthController@remind');

    $router->post('password-reset', 'AuthController@reset');

    Route::group(['prefix' => '', 'middleware' => ['role:user|admin']], function () use ($router) {
        // Matches "/api/profile
        $router->get('profile', 'UserController@profile');

        Route::group(['prefix' => '', 'middleware' => ['role:user']], function () use ($router) {
            $router->post('todo-add', 'TodoController@addTodo');
            $router->post('todo-update', 'TodoController@updateTodo');
        });

        Route::group(['prefix' => '', 'middleware' => ['role:admin']], function () use ($router) {
            // Matches "/api/user
            //get one user by id
            $router->get('users/{id}', 'UserController@singleUser');

            // Matches "/api/users
            $router->get('users', 'UserController@allUsers');

            $router->get('todo-list', 'TodoController@todoList');

            $router->post('todo-delete', 'TodoController@deleteTodo');

            $router->get('activity-log', 'LogController@activityLog');
        });
    });
});

