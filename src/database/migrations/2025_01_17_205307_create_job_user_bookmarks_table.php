<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_user_bookmarks', function (Blueprint $table) {
            $table->id();
            # Laravel knows that user_id is a foreign key that references the id column on the users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            # Let laravel know that job_id is a foreign key that references the id column on the job_listings table
            $table->foreignId('job_id')->constrained('job_listings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_user_bookmarks');
    }
};
