<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Following;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Series of tests for Follow API.
     *
     * @return void
     */
    public function test_api_follow()
    {
        // Create followers

        $followee = User::factory()->create([
            'username' => 'Elon',
            'name' => 'Elon Musk',
        ]);

        $followerI = User::factory()->create([
            'username' => 'Angelo',
            'name' => 'Angelo Salvador',
        ]);

        // Follow first user using second user's account

        $followAPIResponse = $this->post('/api/users/Elon/follow', ['follower_id' => $followerI->id]);
        $followAPIResponse->assertStatus(200);

        // Access first user's followers

        $userFollowersAPIResponse = $this->get('/api/users/Elon/followers');
        $userFollowersAPIResponse->assertStatus(200);

        $followers = $userFollowersAPIResponse->json()['data'];

        $this->assertEquals(1, count($followers));

        // Filter first user's follower by name

        $userFollowersFilteredAPIResponse = $this->get('/api/users/Elon/followers?name=Angelo');
        $userFollowersFilteredAPIResponse->assertStatus(200);

        $filteredFollowers = $userFollowersFilteredAPIResponse->json()['data'];

        $this->assertEquals(1, count($filteredFollowers));

        // Unfollow first user using second user's account

        $unfollowAPIResponse = $this->post('/api/users/Elon/unfollow', ['follower_id' => $followerI->id]);
        $unfollowAPIResponse->assertStatus(200);

        // Re-access first user's followers

        $userFollowersAPIResponseII = $this->get('/api/users/Elon/followers');
        $userFollowersAPIResponseII->assertStatus(200);

        $followersII = $userFollowersAPIResponseII->json()['data'];

        $this->assertEquals(0, count($followersII));
    }
}
