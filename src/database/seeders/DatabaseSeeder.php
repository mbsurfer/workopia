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

        $user_file_destination = storage_path('app/public/users');
        if (File::exists($user_file_destination)) {
            File::deleteDirectory($user_file_destination);
            $this->command->info('Deleted existing user storage directory.');
        }

        DB::table('job_user_bookmarks')->truncate();
        $this->command->info('Truncated job_user_bookmarks table.');

        DB::table('applicants')->truncate();
        $this->command->info('Truncated applicants table.');

        $applicant_file_destination = storage_path('app/public/applicants');
        if (File::exists($applicant_file_destination)) {
            File::deleteDirectory($applicant_file_destination);
            $this->command->info('Deleted existing applicant storage directory.');
        }

        $this->call([
            TestUserSeeder::class,
            RandomUserSeeder::class,
            JobSeeder::class,
            BookmarkSeeder::class
        ]);
    }
}
