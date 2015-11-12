<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class ScheduleEmployee Implements DomainInterface
{
    public function __invoke(array $input)
    {
        $manager_id = $input['manager_id'];
        $employee_id = $input['employee_id'];
        $break = $input['break'];
        $start_time = urldecode($input['start_time']);  // to account for the %20 in RFC 2822 date
        $end_time = urldecode($input['end_time']);      // to account for the %20 in RFC 2822 date
        $created_at = date("Y-m-d H:i:s");


        /* --  input sanitization -- */
        if (!is_numeric($manager_id) || !is_numeric($employee_id))
            exit;

        // Spark is having trouble with a floating point in the url
        if (!is_numeric($break) || strlen($break) > 3) {
            $break = 0.00;
        } else {
            if (strlen($break) == 3) {
                $break = substr($break, 0, 1) . "." . substr($break, -2);
            }
            if (strlen($break) == 2) {
                $break = ".$break";
            }
        }


        // todo: start and end time sanitization

        /* -- end input sanitization -- */

echo "$break\n"; exit;
        $db = new Database('localhost', 'test', '_!p@ssw0rd!@', 'wheniwork');
        $query = "INSERT INTO shift (
                      manager_id,
                      employee_id,
                      break,
                      start_time,
                      end_time,
                      created_at
                  )
                  VALUES (
                      $manager_id,
                      $employee_id,
                      $break,
                      '$start_time',
                      '$end_time',
                      '$created_at'
                  )";


        $result = $db->query($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = json_encode($row);
        }

        // finalize JSON format
        $payload_str = "[" . implode(",", $output) . "]";
        
        return (new Payload)
            ->withStatus(Payload::OK)
            ->withOutput(array($payload_str));
    }
}  
