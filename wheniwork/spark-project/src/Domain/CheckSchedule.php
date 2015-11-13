<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use utils\Database;

class CheckSchedule Implements DomainInterface
{
    public function __invoke(array $input)
    {
        $start_time = urldecode($input['start_time']);  // to account for the %20 in RFC 2822 date
        $end_time = urldecode($input['end_time']);      // to account for the %20 in RFC 2822 date

        // input validation
        if (!is_numeric(strtotime($start_time)) || !is_numeric(strtotime($end_time))) {
            return (new Payload)
                ->withStatus(Payload::INVALID)
                ->withOutput(array("Invalid Request: Bad date interval"));
        }

        // query database
        $db = new Database();
        $result = $db->query("SELECT * FROM shift WHERE
                                start_time >= '$start_time' AND
                                end_time <= '$end_time'");

        while ($row = mysqli_fetch_assoc($result)) {
            $output[] = json_encode($row);
        }

        $output = json_encode($output);

        return (new Payload)
            ->withStatus(Payload::OK)
            ->withOutput(array($output));
    }
}
