<?php

namespace App\Repositories;

use App\Models\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UsersRepository
{
    /**
     * Get all users
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return User::all();
    }

    /**
     * Fetch/filter followers by username
     *
     * @param string $userName
     * @param string $nameFilter
     *
     * @return Collection
     */
    public function followers(string $userName, string $nameFilter = ''): Collection
    {
        $users = DB::table('users AS inner_user')->select([
            'outer_users.id',
            'outer_users.name',
            'outer_users.username',
            'outer_users.email',
            'outer_users.address_street',
            'outer_users.address_suite',
            'outer_users.address_city',
            'outer_users.address_zipcode',
            'outer_users.address_geo_lat',
            'outer_users.address_geo_lng',
            'outer_users.phone',
            'outer_users.website',
            'outer_users.company_name',
            'outer_users.company_catch_phrase',
            'outer_users.company_business_strength',
        ]);

        $users = $users->join('followings', 'followings.followee_id', '=', 'inner_user.id')
            ->join('users AS outer_users', 'outer_users.id', '=', 'followings.follower_id')
            ->where('inner_user.username', $userName);

        if (!empty($nameFilter)) {
            $nameFilter = strtolower($nameFilter);
            $users = $users->whereRaw('LOWER(outer_users.name) LIKE "%'.$nameFilter.'%"');
        }

        return $users->get();
    }
}
