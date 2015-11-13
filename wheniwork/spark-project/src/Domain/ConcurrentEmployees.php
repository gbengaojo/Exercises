<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class ConcurrentEmployees Implements DomainInterface
{
    public function __invoke(array $input)
    {
        $employee_id = $input['employee_id'];

        // input sanitization
        if (!is_numeric($employee_id)) {
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request"));            
        }

        // get start and end times for this user
        $db = new Database();
        $result = $db->query("SELECT
                                  start_time,
                                  end_time
                              FROM
                                  shift
                              WHERE
                                  employee_id = $employee_id");

        while ($row = mysqli_fetch_assoc($result)) {
            $times[] = $row;
        }

        // construct query to get all users within this users shifts
        $query = "SELECT DISTINCT user.id FROM shift LEFT JOIN user ON employee_id WHERE (";
        foreach ($times as $time) {
            $query .= "(start_time BETWEEN '" . $time['start_time'] . "' AND '" . $time['end_time'] . "') OR " .
                      "(end_time BETWEEN '" . $time['start_time'] . "' AND '" . $time['end_time'] . "') AND ";
        }
        // strip trailing AND, close parenthesis, and add final conditions
        $query = substr($query, 0, -5) . ") AND user.role != 'manager' AND user.id != $employee_id";

        // execute query
        $result = $db->query($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = json_encode($row);
        }

        // finalize JSON
        $payload_str = "[" . implode(",", $output) . "]";
        
        return (new Payload)
            ->withStatus(Payload::OK)
            ->withOutput(array($payload_str));
    }
}  
