<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'event_id' => $this->generateEventEventId(), // Custom ID format
            'name' => $this->faker->sentence(3), // Random sentence as event name
            'description' => $this->faker->text(50), // Random text for description
            'status' => $this->faker->boolean(80), // Random boolean (80% chance of being true/1)
            'type' => $this->faker->randomElement(['Upcomming', 'Completed']), // Random type
            'event_time' => $this->faker->dateTimeBetween('now', '+7 days'), // Random date/time for event
            'created_by' => 1, // Simulate a user ID
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Generate a unique event_event_id with a custom format.
     *
     * @return string
     */
    private function generateEventEventId()
    {
        return 'REM-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    }
}
