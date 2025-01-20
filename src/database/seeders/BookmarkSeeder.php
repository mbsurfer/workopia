<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Job;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testUser = User::where('email', 'test@test.com')->firstOrFail();

        $jobIds = Job::pluck('id')->toArray();

        // Randomly select 5 job IDs
        $randomJobIds = collect($jobIds)->random(3);

        foreach ($randomJobIds as $jobId) {
            $testUser->bookmarkedJobs()->attach($jobId);
        }
    }
}
