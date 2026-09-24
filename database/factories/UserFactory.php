<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => UserRole::Business,
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an administrator.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Admin,
        ]);
    }

    /**
     * Indicate that the user is an inspector.
     */
    public function inspector(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Inspector,
        ]);
    }

    /**
     * Indicate that the user is a team leader.
     */
    public function teamLeader(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::TeamLeader,
        ]);
    }

    /**
     * Indicate that the user is the head of the office.
     */
    public function head(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Head,
        ]);
    }

    /**
     * Indicate that the user is a business user.
     */
    public function business(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Business,
        ]);
    }
}
