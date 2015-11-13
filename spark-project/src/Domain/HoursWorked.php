<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class HoursWorked Implements DomainInterface
{
    public function __invoke(array $input)
    {
        $employee_id = $input['employee_id'];

        // input sanitization
        if (!is_numeric($employee_id)) {
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request: Bad employee id"));            
        }

        // database
        $db = new Database('localhost', 'test', '_!p@ssw0rd!@', 'wheniwork');
        $query = "select id, employee_id, start_time, end_time, break, WEEKOFYEAR(start_time), DAYOFWEEK(start_time), DAYNAME(start_time), TIMEDIFF(TIMEDIFF(end_time, start_time), SEC_TO_TIME(break*60*60)) AS hours FROM shift WHERE employee_id = 1 ORDER BY start_time";

        $result = $db->query($query);

        // calculate
        while ($row = mysqli_fetch_assoc($result)) {

        }

        // get hours (start_time - end_time - break)
        // get days of week for each start time
        // structure Mon - Sun
        // construct json
echo '<pre>';
print_r($records);











        return (new Payload)
            ->withStatus(Payload::OK)
            ->withOutput(array($output));
    }
}  
