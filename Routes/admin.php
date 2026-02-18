<?php


    $router->get(
     '/admin/dashboard',
     'AdminController@dashboard',
     ['AdminMiddleware']
    );

// Dashboard admin
$router->get(
    '/admin/dashboard', 
    'AdminController@dashboard');

// Gestión clientes
$router->get(
    '/admin/clientes',
    'AdminClienteController@index',
    ['AdminMiddleware']
);

$router->get(
    '/admin/clientes/create',
    'AdminClienteController@create',
    ['AdminMiddleware']
);

$router->post(
    '/admin/clientes/store',
    'AdminClienteController@store',
    ['AdminMiddleware']
);

$router->get(
    '/admin/clientes/delete',
    'AdminClienteController@delete',
    ['AdminMiddleware']
);