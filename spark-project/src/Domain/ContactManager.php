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

        // get the manager_id from $input
        // get the shift_id from $input
        // calculate stuff


        return (new Payload)
            ->withStatus(Payload::OK)
            ->withOutput($output);
    }
}  


/*

        $output = array('key1' => 'value1',
                        'key2' => 'value2',
                        'key3' => 'value3',
                        'key4' => 'value4');
*/
