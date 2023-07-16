<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->count(10)
            ->hasComments(5)
            ->create();

        Post::factory()
            ->count(10)
            ->hasComments(3)
            ->create();
    }
}
