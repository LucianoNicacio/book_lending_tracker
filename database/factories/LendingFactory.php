<?php

namespace Database\Factories;

use App\Models\Lending;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lending>
 */
class LendingFactory extends Factory
{
    protected $model = Lending::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lentAt = $this->faker->dateTimeBetween('-6 months', 'now');
        $dueAt = (clone $lentAt)->modify('+' . rand(7, 30) . ' days');

        // 70% chance it's returned, 30% still out
        $returnedAt = $this->faker->boolean(70)
            ? $this->faker->dateTimeBetween($lentAt, $dueAt)->format('Y-m-d')
            : null;

        return [
            'lent_at'   => $lentAt->format('Y-m-d'),
            'due_at'    => $dueAt->format('Y-m-d'),
            'return_at' => $returnedAt,
        ];
    }
}
