<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class ContactUser Implements DomainInterface
{
    /**
     * this is used to contact either an employee or a manager
     */
    public function __invoke(array $input)
    {
        $user_id = $input['user_id'];
        $role = $input['role'];

        // input sanitization
        if (!is_numeric($user_id)) {
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request: Bad user"));            
        }

        // get contact details
        $db = new Database();
        $result = $db->query("SELECT name, email, phone
                              FROM user
                              WHERE id = $user_id AND role = '$role'");

        $row = mysqli_fetch_assoc($result);
        $output = json_encode($row);

        return (new Payload)
            ->withStatus(Payload::OK)
            ->withOutput(array($output));
    }
}  
