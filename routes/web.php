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

/*$router->get('/', function () use ($router) {
    return $router->app->version();
});*/

$router->get('/', function(){
    return view('download');
});
$router->get('/download', function(){
    return view('download');
});

$router->get('/card/{id}', ['uses' => 'frontController@card']);
$router->get('/vcard/{id}', ['uses' => 'frontController@vcard']);
$router->get('/card/image/{id}', ['uses' => 'frontController@cardImage']);


$router->group(['prefix' => 'api'], function() use ($router){
    $router->get('employee', ['uses' => 'EmployeeController@all']);
    $router->get('employee/{login}', ['uses' => 'EmployeeController@info']);

    $router->get('company', ['uses' => 'CompanyController@all']);
    $router->get('company/{login}', ['uses' => 'CompanyController@show']);
    
});

$router->group(['prefix' => 'portal'], function() use ($router){
    $router->get('update/ios', function(){
        return redirect('https://install.appcenter.ms/users/auttawir/apps/ios-icarddemo/distribution_groups/dev%20public');
    });
    $router->get('update/android', function(){
        return redirect('https://install.appcenter.ms/users/auttawir/apps/android-icarddemo/distribution_groups/dev%20public');
    });
});

//ldap API
$router->group(['prefix' => 'api/ldap'], function() use ($router){

    $router->post('checkAuth', ['uses' => 'LDAPController@checkAuth']);    
    //$router->get('checkAuth/{username}/{password}', ['uses' => 'LDAPController@checkAuth']);    
});

//iCard API
$router->group(['prefix' => 'api/card'], function() use ($router){
    $router->get('nextId', ['uses' => 'ICardController@nextId']);

    $router->post('create', ['uses' => 'ICardController@create']);   
    $router->post('delete', ['uses' => 'ICardController@delete']);

    /*$router->get('create/{userLogin}/{company}/{nameTH}/{lastnameTH}/{nameEN}/{lastnameEN}/{position}/{department}/{contactTel}/{contactDir}/{contactFax}/{email}', ['uses' => 'ICardController@create']);   
    $router->get('delete/{userLogin}/{cardId}', ['uses' => 'ICardController@delete']);*/

    $router->get('of/{username}', ['uses' => 'ICardController@of']);
    
    $router->get('/{id}', ['uses' => 'ICardController@get']);
});
