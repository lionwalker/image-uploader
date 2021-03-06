<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/',function ()  {
    return view('index');
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    $router->post('/file', 'UploadController@create');
    $router->get('/file/{type}/{id}', 'UploadController@show');
    $router->delete('/file/{type}/{id}', 'UploadController@destroy');

});
