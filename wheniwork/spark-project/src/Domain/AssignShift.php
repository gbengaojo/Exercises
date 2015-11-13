<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class AssignShift Implements DomainInterface
{
    public function __invoke(array $input)
    {
        $employee_id = $input['employee_id'];
        $shift_id = $input['shift_id'];

        /* --  input sanitization -- */
        if (!is_numeric($employee_id) || !is_numeric($shift_id)) {
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request"));
        }
        /* -- end input sanitization -- */

        $db = new Database();
        $query = "UPDATE shift SET employee_id = $employee_id
                        WHERE id = $shift_id";

        $result = $db->query($query);
        
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
