<?php

/** @var \Illuminate\Routing\Router $router */

// Logout
$router->post('/logout', 'LoginController@logout');
