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

use Illuminate\Support\Str;

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/app-key', function (){
    return Str::random(32);
});
$router->get('/jwt-secret', function (){
    return 'PuXzdUhLho9FmhLPoGgJVzdGuKtS8cgPFYanIjgmZEvvc0yJFUbqWXdZBNyS2R1P';
});
$router->post('/api/auth/login', 'Auth\AuthController@login');
$router->post('/register', 'Auth\AuthController@register');
$router->get('/troubleshoot/category/{id}', 'TroubleshootArticleController@filterCategory');

$router->group(['middleware' => 'auth'], function() use ($router) {
        $router->get('/api/auth/user', 'UserController@user');
        $router->get('user/{id}', 'UserController@view');
        $router->put('user/{id}', 'UserController@update');
        $router->put('user/{id}/password', 'UserController@updatePassword');

        $router->get('/article', 'ArticleController@index');
        $router->get('/article/{id}', 'ArticleController@filterCategory');
        $router->get('/article/{id}/view', 'ArticleController@view');
        $router->post('/article/', 'ArticleController@save');
        $router->put('/article/{id}', 'ArticleController@save');
        $router->post('/article/', 'ArticleController@publish');
        $router->put('/article/{id}', 'ArticleController@publish');
        $router->delete('/article/{id}', 'ArticleController@destroy');
        $router->get('/test/{id}', 'ThisControllerIsForTestingOnlyController@test');

        $router->post('/search[/{query}]', 'SearchDataController@result');
        $router->get('/test/{id}', 'ThisControllerIsForTestingOnlyController@test');
        $router->get('/category', 'InterestCategoryController@index');
        $router->post('/logout', 'Auth\AuthController@logout');
    }
);
