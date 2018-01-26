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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/card/{id}', ['uses' => 'frontController@card']);

$router->group(['prefix' => 'api'], function() use ($router){
    $router->get('employee', ['uses' => 'EmployeeController@all']);
    $router->get('employee/{login}', ['uses' => 'EmployeeController@info']);

    $router->get('company', ['uses' => 'CompanyController@all']);
    
});

//ldap API
$router->group(['prefix' => 'api/ldap'], function() use ($router){

    $router->post('checkAuth', ['uses' => 'LDAPController@checkAuth']);    
});

//iCard API
$router->group(['prefix' => 'api/card'], function() use ($router){
    $router->get('nextId', ['uses' => 'ICardController@nextId']);        
    $router->post('create', ['uses' => 'ICardController@create']);   
    $router->post('delete', ['uses' => 'ICardController@delete']);   
    $router->get('of/{username}', ['uses' => 'ICardController@of']);
    $router->get('fake', ['uses' => 'ICardController@fakeGet']);
    
    $router->get('/{id}', ['uses' => 'ICardController@get']);   
});
