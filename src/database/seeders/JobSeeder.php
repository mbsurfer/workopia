<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\File;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load job listings from file
        $jobListings = include database_path('seeders/data/job_listings.php');

        // Get test user id
        $testUserId = User::where('email', 'test@test.com')->value('id');

        // Get all other user ids from user model
        $userIds = User::where('email', '!=', 'test@test.com')->pluck('id')->toArray();

        foreach ($jobListings as $key => &$job) {
            $job['user_id'] = ($key < 2) ? $testUserId : $userIds[array_rand($userIds)];
            $job['created_at'] = now();
            $job['updated_at'] = now();
        }

        // Insert job listings into database
        DB::table('job_listings')->insert($jobListings);
        $this->command->info('Inserted job_listing records.');

        // Copy seed images to storage
        $source = database_path('seeders/files/jobs');
        $destination = storage_path('app/public/jobs');

        $this->command->info('Deleting existing job storage directory.');
        if (File::exists($destination)) {
            File::deleteDirectory($destination);
        }

        File::copyDirectory($source, $destination);
        $this->command->info('Copied job files to storage.');
    }
}
