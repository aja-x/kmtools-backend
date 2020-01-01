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
$router->get('/app-key', function () {
    return Str::random(32);
});
$router->get('/jwt-secret', function () {
    return 'PuXzdUhLho9FmhLPoGgJVzdGuKtS8cgPFYanIjgmZEvvc0yJFUbqWXdZBNyS2R1P';
});
$router->post('/api/auth/login', 'Auth\AuthController@login');
$router->post('/register', 'Auth\AuthController@register');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/api/auth/user', 'UserController@user');
    $router->get('/auth/user/get-category', 'UserController@getUserRole');
    $router->post('/auth/user/category', 'UserController@setInterestCategory');
    $router->put('/auth/user/password', 'UserController@updatePassword');
    $router->put('/auth/user', 'UserController@update');
    $router->delete('/auth/user', 'UserController@destroy');
    $router->get('/user/{id}', 'UserController@view');

    $router->get('/category', 'InterestCategoryController@index');

    $router->get('/article', 'ArticleController@index');
    $router->get('/article/recommendation', 'ArticleController@recommendation');
    $router->get('/article/{id}', 'ArticleController@view');
    $router->post('/article/save', 'ArticleController@saveNewArticle');
    $router->put('/article/{id}/save', 'ArticleController@saveExistingArticle');
    $router->post('/article/publish', 'ArticleController@publishNewArticle');
    $router->put('/article/{id}/publish', 'ArticleController@publishExistingArticle');

    $router->get('/error-report', 'ErrorReportController@index');
    $router->get('/error-report/{id}', 'ErrorReportController@view');
    $router->post('/error-report', 'ErrorReportController@store');
    $router->put('/error-report/{id}', 'ErrorReportController@update');
    $router->delete('/error-report/{id}', 'ErrorReportController@destroy');

    $router->get('/troubleshoot', 'TroubleshootArticleController@index');
    $router->get('/troubleshoot/{id}/category', 'TroubleshootArticleController@filterCategory');
    $router->get('/troubleshoot/{id}', 'TroubleshootArticleController@view');
    $router->post('/troubleshoot/save', 'TroubleshootArticleController@save');
    $router->put('/troubleshoot/{id}/save', 'TroubleshootArticleController@save');
    $router->post('/troubleshoot/publish', 'TroubleshootArticleController@publish');
    $router->put('/troubleshoot/{id}/publish', 'TroubleshootArticleController@publish');

    $router->post('/search[/{query}]', 'ActivityHistoryController@searchResult');

    $router->get('/article/{id}/comments', 'CommentController@getArticleComments');
    $router->post('/comment', 'CommentController@store');
    $router->put('/comment/{id}', 'CommentController@update');
    $router->delete('/comment/{id}', 'CommentController@destroy');

    $router->get('/user/activity/article', 'ActivityHistoryController@getArticleActivity');
    $router->get('/user/activity/error-report', 'ActivityHistoryController@getErrorReportActivity');
    $router->get('/user/{id}/activity/article', 'ActivityHistoryController@getArticleActivity');
    $router->get('/user/{id}/activity/error-report', 'ActivityHistoryController@getErrorReportActivity');

    $router->get('/test/{id}', 'ThisControllerIsForTestingOnlyController@test');

    $router->post('/logout', 'Auth\AuthController@logout');
});
