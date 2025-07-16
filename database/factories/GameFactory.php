<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Game;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'intro' => fake()->regexify('[A-Za-z0-9]{255}'),
            'overview' => fake()->text(),
            'instruction' => fake()->text(),
            'thumbnail' => fake()->regexify('[A-Za-z0-9]{255}'),
            'image' => fake()->regexify('[A-Za-z0-9]{255}'),
            'gif' => fake()->regexify('[A-Za-z0-9]{255}'),
            'video' => fake()->regexify('[A-Za-z0-9]{255}'),
            'url' => fake()->url(),
        ];
    }
}
