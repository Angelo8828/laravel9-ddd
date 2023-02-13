<?php

namespace Tests\Feature;

use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A test for Users API
     *
     * @return void
     */
    public function test_api_users()
    {
        // Create 2 users

        User::factory()->count(2)->create();

        // Access users API

        $usersAPIResponse = $this->get('/api/users');
        $usersAPIResponse->assertStatus(200);

        $users = $usersAPIResponse->json()['data'];

        // Check if API data count matches the number of total records

        $this->assertEquals(2, count($users));

        $this->assertArrayHasKey('id', $users[0]);
        $this->assertArrayHasKey('name', $users[0]);
        $this->assertArrayHasKey('username', $users[0]);
        $this->assertArrayHasKey('email', $users[0]);
        $this->assertArrayHasKey('address', $users[0]);
        $this->assertArrayHasKey('phone', $users[0]);
        $this->assertArrayHasKey('website', $users[0]);
        $this->assertArrayHasKey('company', $users[0]);

        $this->assertArrayHasKey('street', $users[0]['address']);
        $this->assertArrayHasKey('suite', $users[0]['address']);
        $this->assertArrayHasKey('city', $users[0]['address']);
        $this->assertArrayHasKey('zipcode', $users[0]['address']);
        $this->assertArrayHasKey('geo', $users[0]['address']);

        $this->assertArrayHasKey('lat', $users[0]['address']['geo']);
        $this->assertArrayHasKey('lng', $users[0]['address']['geo']);

        $this->assertArrayHasKey('name', $users[0]['company']);
        $this->assertArrayHasKey('catchPhrase', $users[0]['company']);
        $this->assertArrayHasKey('bs', $users[0]['company']);
    }
}
