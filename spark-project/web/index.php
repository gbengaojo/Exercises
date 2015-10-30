<?php

require __DIR__ . '/../vendor/autoload.php';

$app = Spark\Application::boot();

$app->setMiddleware([
    'Relay\Middleware\ResponseSender',
    'Spark\Handler\ExceptionHandler',
    'Spark\Handler\RouteHandler',
    'Spark\Handler\ContentHandler',
    'Spark\Handler\ActionHandler',
]);

$app->addRoutes(function (Spark\Router $r) {
    $r->get('/hello[/{name}]', 'Spark\Project\Domain\Hello');     // use this to pass parameters to the API
    $r->post('/hello[/{name}]', 'Spark\Project\Domain\Hello');    // as well as set the appropriate HTTP
});                                                               // method (POST, GET, PUT, DELETE)

$app->run();
