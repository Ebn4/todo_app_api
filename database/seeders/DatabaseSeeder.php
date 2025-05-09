<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Task::factory(50)->create();
        User::factory(50)->create();

        // User::factory()->create([
            // 'name' => "test",
            // 'email' => "test@gmail.com",
            // 'password' => Hash::make("password"),
        // ]);
    }
}
