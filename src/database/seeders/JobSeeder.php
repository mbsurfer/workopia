<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load job listings from file
        $jobListings = include database_path('seeders/data/job_listings.php');

        // Get user ids from user model
        $userIds = User::pluck('id')->toArray();

        // Add user_id and timestamp to job listings
        $jobListings = array_map(function ($job) use ($userIds) {
            $job['user_id'] = $userIds[array_rand($userIds)];
            $job['created_at'] = now();
            $job['updated_at'] = now();
            return $job;
        }, $jobListings);

        // Insert job listings into database
        DB::table('job_listings')->insert($jobListings);

        echo "Jobs created successfully.\n";
    }
}
