<?php

namespace App\Domains\Followings;

use App\Domains\Followings\Specs\FollowInputSpec;
use App\Domains\Followings\Specs\FollowOutputSpec;
use App\Domains\Followings\Specs\UnfollowInputSpec;
use App\Domains\Followings\Specs\UnfollowOutputSpec;

interface ServiceInterface
{
    /**
     * Method for following users
     *
     * @param FollowInputSpec $input
     *
     * @return FollowOutputSpec
     */
    public function follow(FollowInputSpec $input): FollowOutputSpec;

    /**
     * Method for unfollowing users
     *
     * @param UnfollowInputSpec $input
     *
     * @return UnfollowOutputSpec
     */
    public function unfollow(UnfollowInputSpec $input): UnfollowOutputSpec;
}
