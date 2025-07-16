<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'category_id' => 1,
                'title' => 'Fruit Ninja',
                'slug' => 'fruit-ninja',
                'intro' => 'Slice fruits with precision!',
                'overview' => 'A fast-paced fruit-slicing game where timing is everything.',
                'instruction' => 'Swipe to slice fruits. Avoid bombs.',
                'thumbnail' => 'games/fruit-ninja-thumb.png',
                'image' => 'games/fruit-ninja.png',
                'gif' => 'games/fruit-ninja.gif',
                'video' => 'videos/fruit-ninja.mp4',
                'url' => 'https://example.com/games/fruit-ninja'
            ],
            [
                'category_id' => 1,
                'title' => 'Space Invaders',
                'slug' => 'space-invaders',
                'intro' => 'Defend Earth from alien invaders!',
                'overview' => 'Shoot waves of descending aliens before they destroy you.',
                'instruction' => 'Use arrow keys to move. Press space to shoot.',
                'thumbnail' => 'games/space-invaders-thumb.png',
                'image' => 'games/space-invaders.png',
                'gif' => 'games/space-invaders.gif',
                'video' => 'videos/space-invaders.mp4',
                'url' => 'https://example.com/games/space-invaders'
            ],
            [
                'category_id' => 1,
                'title' => 'Flappy Bird',
                'slug' => 'flappy-bird',
                'intro' => 'Fly the bird through pipes!',
                'overview' => 'Tap to keep the bird airborne and navigate through pipes.',
                'instruction' => 'Tap to flap. Don’t hit anything.',
                'thumbnail' => 'games/flappy-bird-thumb.png',
                'image' => 'games/flappy-bird.png',
                'gif' => 'games/flappy-bird.gif',
                'video' => 'videos/flappy-bird.mp4',
                'url' => 'https://example.com/games/flappy-bird'
            ],
            [
                'category_id' => 1,
                'title' => 'Tetris',
                'slug' => 'tetris',
                'intro' => 'Fit blocks to clear lines!',
                'overview' => 'Classic puzzle game where you align falling blocks.',
                'instruction' => 'Arrow keys to move/rotate blocks.',
                'thumbnail' => 'games/tetris-thumb.png',
                'image' => 'games/tetris.png',
                'gif' => 'games/tetris.gif',
                'video' => 'videos/tetris.mp4',
                'url' => 'https://example.com/games/tetris'
            ],
            [
                'category_id' => 1,
                'title' => 'Angry Birds',
                'slug' => 'angry-birds',
                'intro' => 'Smash pigs with birds!',
                'overview' => 'Use a slingshot to launch birds and destroy pig fortresses.',
                'instruction' => 'Drag, aim, and release to launch.',
                'thumbnail' => 'games/angry-birds-thumb.png',
                'image' => 'games/angry-birds.png',
                'gif' => 'games/angry-birds.gif',
                'video' => 'videos/angry-birds.mp4',
                'url' => 'https://example.com/games/angry-birds'
            ],
        ];
        Game::insert($games);
    }
}
