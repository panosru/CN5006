<?php
declare(strict_types=1);

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

use App\Enums\AppRole;
use App\Models\MovieModel;

$router->group(['prefix' => '/'], function () use ($router) {

    $router->get('/', function () {

        $movies = MovieModel::all();

        return view('home', [
            'homeActive' => 'active',
            'aboutActive' => '',
            'profileActive' => '',
            'contactActive' => '',
            'movies' => $movies
        ]);
    });

    $router->get('/about', function () {
        return view('about', [
            'homeActive' => '',
            'aboutActive' => 'active',
            'profileActive' => '',
            'contactActive' => ''
        ]);
    });

    $router->get('/profile', function () {
        return view('profile', [
            'homeActive' => '',
            'aboutActive' => '',
            'profileActive' => 'active',
            'contactActive' => ''
        ]);
    });

    $router->get('/contact', function () {
        return view('contact', [
            'homeActive' => '',
            'aboutActive' => '',
            'profileActive' => '',
            'contactActive' => 'active'
        ]);
    });

    $router->get('/test', function () use ($router) {
        return $router->app->version();
    });
});

// API Routes
$router->group(['prefix' => 'api'], function () use ($router) {

    // Authenticated Routes
    $router->group(['middleware' => ['auth', 'role:'.AppRole::USER->value]],
        function () use ($router) {

        // Admin-only Routes
        $router->group(['middleware' => ['role:'.AppRole::ADMIN->value]],
            function () use ($router) {
            $router->post('/options', 'OptionsController@store');
            $router->put('/options/{key}', 'OptionsController@update');
            $router->delete('/options/{key}', 'OptionsController@delete');
        });

        // Staff & Admin Routes
        $router->group(['middleware' => [
            'role:'.AppRole::STAFF->value.'|'.AppRole::ADMIN->value
        ]], function () use ($router) {
            $router->get('/users', 'UserController@index');
            $router->get('/users/{id}', 'UserController@show');
            $router->put('/users/{id}', 'UserController@update');
            $router->delete('/users/{id}', 'UserController@delete');
            $router->get('/user/roles', 'UserController@roles');

            $router->post('/movies', 'MovieController@store');
            $router->get('/movies/find', 'MovieController@find');
            $router->put('/movies/{id}', 'MovieController@update');
            $router->delete('/movies/{id}', 'MovieController@delete');

            $router->post('/halls', 'HallController@store');
            $router->put('/halls/{number}', 'HallController@update');
            $router->delete('/halls/{number}', 'HallController@delete');

            $router->post('/shows', 'ShowController@store');
            $router->get('/shows/{id}/tickets', 'ShowController@showTickets');
            $router->put('/shows/{id}', 'ShowController@update');
            $router->delete('/shows/{id}', 'ShowController@delete');

            $router->get('/tickets', 'TicketController@index');
            $router->get('/tickets/{id}', 'TicketController@show');
            $router->post('/tickets', 'TicketController@store');
            $router->put('/tickets/{id}', 'TicketController@update');
            $router->delete('/tickets/{id}', 'TicketController@delete');

            $router->get('/roles', 'AclController@roles');
            $router->get('/options', 'OptionsController@index');
        });

        // Authenticated Users Routes
        $router->get('/user/logout', 'UserController@logout');
        $router->get('/user/profile', 'UserController@profile');
        $router->get('/user/tickets', 'UserController@tickets');
        $router->post('/tickets/book', 'TicketController@book');
    });

    // Public Routes
    $router->post('/user/register', 'UserController@register');
    $router->post('/user/auth', 'UserController@authneticate');

    $router->get('/movies', 'MovieController@index');
    $router->get('/movies/{id}', 'MovieController@show');

    $router->get('/halls', 'HallController@index');
    $router->get('/halls/{number}', 'HallController@show');

    $router->get('/options/{key}', 'OptionsController@show');

    $router->get('/shows', 'ShowController@index');
    $router->get('/shows-future', 'ShowController@future');
    $router->get('/shows/{id}', 'ShowController@show');
});
