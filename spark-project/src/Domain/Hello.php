<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

// sample domain?
// sample action, according to http://paul-m-jones.com/archives/6006
class Hello implements DomainInterface
{
    public function __invoke(array $input)
    {
        /**
         * this sample domain can be abstracted to a separate class
         * with its resulting data passed to the responder...
         */
        // sample domain               
        $name = 'world';

        if (!empty($input['name'])) {
            $name = $input['name'];
        }
        // end sample domain

        /**
         * ...which can itself be abstraced to a separate class
         * that provides the response presentation; the appropriate
         * output aruguments could be passed to the responder
         */
        // sample responder
        return (new Payload)
            ->withStatus(Payload::OK)
            ->withOutput([
                'hello' => "<h1>$name</h1>",
            ]);
    }
}
