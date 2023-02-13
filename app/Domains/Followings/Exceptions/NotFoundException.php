<?php

namespace App\Domains\Followings\Exceptions;

class NotFoundException extends \Exception
{
    static function make()
    {
        return new NotFoundException("User not being followed");
    }
}
