<?php

namespace App\Domains\Followings\Exceptions;

class SameIDException extends \Exception
{
    static function make()
    {
        return new SameIDException("Follower and followee are the same");
    }
}
