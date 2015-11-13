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
        $db = new Database();
        $query = "SELECT
                        id,
                        employee_id,
                        start_time,
                        end_time,
                        break,
                        WEEKOFYEAR(start_time) AS week,
                        DAYOFWEEK(start_time) AS dayofweek,
                        DAYNAME(start_time) AS day,
                        TIMEDIFF(TIMEDIFF(end_time, start_time),
                        SEC_TO_TIME(break*60*60)) AS hours
                  FROM
                        shift
                  WHERE
                        employee_id = $employee_id ORDER BY start_time";

        $result = $db->query($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
        }

        foreach ($records as $record) {
            $output[$record['id']][$week] = array(
                                'date' => date("F j, Y", strtotime($record['start_time'])),
                                'week' => $record['week'],
                                'day' => $record['day'],
                                'start_time' => $record['start_time'],
                                'end_time' => $record['end_time'],
                                'break' => $record['break'],
                                'hours' => $record['hours']);
        }

        // construct json
        $payload_str = json_encode($output);

        return (new Payload)
            ->withStatus(Payload::OK)
            ->withOutput(array($payload_str));
    }
}  
