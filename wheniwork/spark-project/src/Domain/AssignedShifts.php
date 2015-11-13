<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class AssignedShifts Implements DomainInterface
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

        $db = new Database();
        $result = $db->query("SELECT * FROM shift WHERE employee_id = $employee_id");

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
