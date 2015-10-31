<?php

$conn = mysqli_connect('localhost', 'test', '_!p@ssw0rd!@');
if (!$conn) {
   echo "<pre>no available database connection. :(</pre>";
} else {
   mysqli_select_db($conn, 'test');

   $query = "SELECT * FROM user";
   $result = mysqli_query($conn, $query);

   echo '<pre>';
   print_r($result);
}



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
- create dummy MySQL accout so we can version this code
*/
