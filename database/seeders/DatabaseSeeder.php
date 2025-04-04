<?php

namespace Database\Seeders;

use App\Models\Task;
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
        Task::factory(50)->create();

        // Task::factory()->create([
        //     'title' => 'Apprendre le java',
        //     'description' => 'I have to java python for my new job',
        // ]);
    }
}
