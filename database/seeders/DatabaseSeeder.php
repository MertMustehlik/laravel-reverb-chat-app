<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com'
//        ]);

        User::query()->create([
            'name' => 'Test User - 1',
            'email' => 'test@example.com',
            'password' => '123123'
        ]);

        User::query()->create([
            'name' => 'Test User - 2',
            'email' => 'test2@example.com',
            'password' => '123123'
        ]);

        Conversation::query()->create(['name' => 'Room - 1']);
        Conversation::query()->create(['name' => 'Room - 2']);
        Conversation::query()->create(['name' => 'Room - 3']);
    }
}
