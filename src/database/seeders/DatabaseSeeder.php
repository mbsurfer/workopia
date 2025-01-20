<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

        $this->command->info('Deleting existing user storage directory.');
        $user_file_destination = storage_path('app/public/users');
        if (File::exists($user_file_destination)) {
            File::deleteDirectory($user_file_destination);
        }

        DB::table('job_user_bookmarks')->truncate();
        $this->command->info('Truncated job_user_bookmarks table.');

        $this->call([
            TestUserSeeder::class,
            RandomUserSeeder::class,
            JobSeeder::class,
            BookmarkSeeder::class
        ]);
    }
}
