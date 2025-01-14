<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('job_listings')->truncate();
        $this->command->info('Truncated job_listings table.');

        DB::table('users')->truncate();
        $this->command->info('Truncated users table.');

        $this->call([
            TestUserSeeder::class,
            RandomUserSeeder::class,
            JobSeeder::class,
        ]);
    }
}
