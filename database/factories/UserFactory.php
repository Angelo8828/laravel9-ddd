<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'                      => fake()->name(),
            'username'                  => fake()->firstName(),
            'email'                     => fake()->unique()->safeEmail(),
            'email_verified_at'         => now(),
            'password'                  => Hash::make('p@ssw0rd'),
            'remember_token'            => Str::random(10),
            'address_street'            => fake()->streetName(),
            'address_suite'             => fake()->secondaryAddress(),
            'address_city'              => fake()->city(),
            'address_zipcode'           => fake()->postcode(),
            'address_geo_lat'           => fake()->latitude(),
            'address_geo_lng'           => fake()->longitude(),
            'phone'                     => fake()->phoneNumber(),
            'website'                   => fake()->domainName(),
            'company_name'              => fake()->company(),
            'company_catch_phrase'      => fake()->catchPhrase(),
            'company_business_strength' => fake()->bs(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
