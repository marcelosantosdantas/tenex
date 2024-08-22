<?php

  

$router->get('/', function () use ($router) {
    return $router->app->version();
});


 
 
$router->get('/docs', function () {
    return redirect('/swagger-ui/index.html');
});

// @var \Laravel\Lumen\Routing\Router $router 
$router->group(['prefix' => 'carne'], function () use ($router) {
    $router->post('/', 'CarneController@criarCarne');
    $router->get('/{id}/parcelas', 'CarneController@recuperarParcelas');
    $router->get('/version', function () use ($router) {
        return $router->app->version();
    });
});
