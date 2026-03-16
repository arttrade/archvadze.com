<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $status = $this->faker->randomElement($statuses);

        $projectTypes = ['website', 'e-commerce', 'web-app', 'mobile-app', 'redesign', 'maintenance'];

        return [
            'client_id' => Client::factory(),
            'title' => $this->faker->sentence(4, 8),
            'description' => $this->faker->paragraphs(2, true),
            'status' => $status,
            'project_type' => $this->faker->randomElement($projectTypes),
            'budget' => $this->faker->numberBetween(1000, 50000),
            'deadline' => $this->faker->dateTimeBetween('now', '+6 months'),
            'completed_at' => $status === 'completed' ? $this->faker->dateTimeBetween('-3 months', 'now') : null,
            'created_at' => $this->faker->dateTimeBetween('-6 months', '-1 week'),
            'updated_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    /**
     * Indicate that the project is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the project is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the project is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completed_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ]);
    }

    /**
     * Indicate that the project is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'completed_at' => null,
        ]);
    }
}