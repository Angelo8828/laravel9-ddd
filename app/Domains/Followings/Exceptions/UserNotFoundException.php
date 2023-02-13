<?php

namespace App\Domains\Followings\Exceptions;

class UserNotFoundException extends \Exception
{
    static function make()
    {
        return new UserNotFoundException("Username not existing");
    }
}
