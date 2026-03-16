<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectMessage>
 */
class ProjectMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messages = [
            "I've started working on the initial design concepts for your website.",
            "The development phase is now underway. I'll keep you updated on progress.",
            "I've completed the first draft of the homepage. Would you like to review it?",
            "We're making good progress on the backend functionality.",
            "I've implemented the contact form and it's ready for testing.",
            "The website is now live! Please check it out and let me know your thoughts.",
            "I've made the requested changes to the color scheme.",
            "The mobile responsiveness has been optimized.",
            "All features have been implemented and tested.",
            "We're just doing final quality checks before launch.",
        ];

        return [
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
            'message' => $this->faker->randomElement($messages),
            'is_read' => $this->faker->boolean(70), // 70% chance of being read
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }

    /**
     * Indicate that the message has been read.
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => true,
        ]);
    }

    /**
     * Indicate that the message is unread.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => false,
        ]);
    }
}