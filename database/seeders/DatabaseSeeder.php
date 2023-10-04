<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'username' => 'test.user',
        //     'email' => 'test@example.com',
        // ]);


        User::factory()
            ->count(10)
            ->hasPosts(3)
            ->create();
        
        // Comment::factory(15)->create();
        // Comment::factory()->create([
        //     'post_id' => 1,
        //     'user_id' => 51,
        //     'title' => 'title',
        //     'content' => 'content',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // User::factory()
        //     ->count(25)
        //     ->hasPosts(3)
        //     ->create();
    }
}
