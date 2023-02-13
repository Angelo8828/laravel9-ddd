<?php

namespace App\Domains\Followings\Exceptions;

class AlreadyExistingException extends \Exception
{
    static function make()
    {
        return new AlreadyExistingException("User already followed");
    }
}
