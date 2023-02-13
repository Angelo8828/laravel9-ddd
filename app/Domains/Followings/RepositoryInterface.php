<?php

namespace App\Domains\Followings;

use App\Domains\Followings\Entities\Following;
use App\Domains\Followings\Entities\User;

interface RepositoryInterface
{
    /**
     * Get following
     *
     * @param Following $following
     *
     * @return Following
     */
    public function get(Following $following): ?Following;

    /**
     * Save following
     *
     * @param Following $following
     *
     * @return Following
     */
    public function save(Following $following): Following;

    /**
     * Delete following
     *
     * @param Following $following
     *
     * @return bool
     */
    public function delete(Following $following): bool;

    /**
     * Get user by username
     *
     * @param string $username
     *
     * @return User
     */
    public function getByUsername(string $username): ?User;
}
