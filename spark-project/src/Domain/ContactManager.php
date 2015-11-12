<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class ContactManager Implements DomainInterface
{
    public function __invoke(array $input)
    {
        $db = new Database('localhost', 'test', '_!p@ssw0rd!@', 'wheniwork');
        $result = $db->query("SELECT * FROM shift WHERE employee_id = 1");

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
