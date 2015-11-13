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
    $r->get('/assignedshifts/[{employee_id}]', 'Spark\Project\Domain\AssignedShifts');
    $r->get('/concurrentemployees/[{employee_id}]', 'Spark\Project\Domain\ConcurrentEmployees');
    $r->get('/hoursworked/[{employee_id}]', 'Spark\Project\Domain\HoursWorked');
    $r->post('/scheduleemployee/[{manager_id}/{employee_id}/{break}/{start_time}/{end_time}]', 'Spark\Project\Domain\ScheduleEmployee');
    $r->get('/checkschedule/[{start_time}/{end_time}]', 'Spark\Project\Domain\CheckSchedule');
    $r->put('/updateshift/[{start_time}/{end_time}/{shift_id}]', 'Spark\Project\Domain\UpdateShift');
    $r->put('/assignshift/[{employee_id}/{shift_id}]', 'Spark\Project\Domain\AssignShift');
    $r->get('/contactuser/[{user_id}/{role}]', 'Spark\Project\Domain\ContactUser');
});


$app->run();
