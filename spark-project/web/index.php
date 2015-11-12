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
    $r->get('/contactmanager/[{manager_id}/{shift_id}]', 'Spark\Project\Domain\ContactManager');

    $r->post('/scheduleemployee/[{manager_id}/{employee_id}/{break}/{start_time}/{end_time}]', 'Spark\Project\Domain\ScheduleEmployee');
});


$app->run();

/*
1. AssignedShifts(employee_id)
2. ConcurrentEmployees(employee_id)
3. HoursWorked(employee_id)
4. ContactManger(manager_id, shift_id)
5. ScheduleEmployees()
6. CheckSchedule(start_time, end_time)
7. UpdateShift(shift_id)
8. AssignShift(employee_id)
9. ContactEmployee(employee_id)
- Look into unit testing for this package
- move Hello.php (and any similar files) to the Action dir
- create MySQL table to store data, and provide a database dump for the deliverable
*/
