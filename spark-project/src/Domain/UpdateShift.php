<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class UpdateShift Implements DomainInterface
{
    public function __invoke(array $input)
    {
        $shift_id = $input['shift_id'];
        $start_time = urldecode($input['start_time']);  // to account for the %20 in RFC 2822 date
        $end_time = urldecode($input['end_time']);      // to account for the %20 in RFC 2822 date

        /* --  input sanitization -- */
        if (!is_numeric($shift_id)) {
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request"));
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

        // Execute query
        $db = new Database('localhost', 'test', '_!p@ssw0rd!@', 'wheniwork');
        $query = "UPDATE shift
                  SET
                      start_time = '$start_time',
                      end_time = '$end_time'
                  WHERE
                      id = $shift_id";

        $result = $db->query($query);
        
        // format payload
        if ($result) {
            $payload_status = Payload::OK;
            $output = array('OK');
        } else {
            $payload_status = Payload::ERROR;
            $output = array('DB write error');
        }
        
        return (new Payload)
            ->withStatus($payload_status)
            ->withOutput($output);
    }
}  
