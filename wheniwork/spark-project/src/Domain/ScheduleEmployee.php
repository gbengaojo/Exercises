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
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request"));

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

        if (!is_numeric(strtotime($start_time))) {
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request: Bad start time"));
        }

        if (!is_numeric(strtotime($end_time))) {
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request: Bad end time"));
        }
        /* -- end input sanitization -- */

        // Database query
        $db = new Database();
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
        
        // format payload
        if ($result) {
            $payload_status = Payload::OK;
            $output = array('OK');
        } else {
            $payload_status = Paylod::ERROR;
            $output = array('DB write error');
        }
        
        return (new Payload)
            ->withStatus($payload_status)
            ->withOutput($output);
    }
}  
