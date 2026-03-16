<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\GuideCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guide>
 */
class GuideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guide::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Getting Started with Web Development',
            'SEO Best Practices for Small Businesses',
            'Choosing the Right Web Hosting Provider',
            'Mobile-First Design Principles',
            'WordPress Security Essentials',
            'E-commerce Platform Comparison',
            'Social Media Integration Guide',
            'Website Performance Optimization',
            'Content Management System Selection',
            'Digital Marketing Strategy Basics',
        ];

        $title = $this->faker->randomElement($titles);

        return [
            'guide_category_id' => GuideCategory::factory(),
            'title' => $title,
            'slug' => $this->faker->unique()->slug(3, 8),
            'content' => $this->faker->paragraphs(15, true),
            'excerpt' => $this->faker->paragraph(),
            'is_published' => $this->faker->boolean(85), // 85% chance of being published
            'published_at' => $this->faker->optional(0.8)->dateTimeBetween('-2 months', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-4 months', '-1 week'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }

    /**
     * Indicate that the guide is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ]);
    }

    /**
     * Indicate that the guide is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}