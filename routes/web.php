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

$router->group(['middleware' => 'auth'], function() use ($router) {
    $router->get('/api/auth/user', 'UserController@user');
    $router->post('/auth/user/category', 'UserController@setInterestCategory');
    $router->put('/auth/user/password', 'UserController@updatePassword');
    $router->put('/auth/user', 'UserController@update');
    $router->delete('/auth/user', 'UserController@destroy');
    $router->get('/user/{id}', 'UserController@view');

    $router->get('/category', 'InterestCategoryController@index');

    $router->get('/article', 'ArticleController@index');
    $router->get('/article/{id}', 'ArticleController@view');
    $router->get('/article/category/{id}', 'ArticleController@filterCategory');
    $router->post('/article/save', 'ArticleController@save');
    $router->put('/article/{id}/save', 'ArticleController@save');
    $router->post('/article/publish', 'ArticleController@publish');
    $router->put('/article/{id}/publish', 'ArticleController@publish');

    $router->get('/troubleshoot', 'TroubleshootArticleController@index');
    $router->get('/troubleshoot/{id}', 'TroubleshootArticleController@view');
    $router->get('/troubleshoot/{id}/category', 'TroubleshootArticleController@filterCategory');
    $router->post('/troubleshoot/save', 'TroubleshootArticleController@save');
    $router->put('/troubleshoot/{id}/save', 'TroubleshootArticleController@save');
    $router->post('/troubleshoot/publish', 'TroubleshootArticleController@publish');
    $router->put('/troubleshoot/{id}/publish', 'TroubleshootArticleController@publish');

    $router->get('/article/{id}/comments', 'CommentController@getArticleComments');
    $router->post('/comment', 'CommentController@store');
    $router->put('/comment/{id}', 'CommentController@update');
    $router->delete('/comment/{id}', 'CommentController@destroy');

    $router->get('/test/{id}', 'ThisControllerIsForTestingOnlyController@test');

    $router->post('/logout', 'Auth\AuthController@logout');
});
