<?php

/** @var \Illuminate\Routing\Router $router */

// Login
$router->post('/login', 'LoginController@login');
$router->post('/login/refresh', 'LoginController@refresh');

// Register
$router->post('/register', 'RegisterController@store');
