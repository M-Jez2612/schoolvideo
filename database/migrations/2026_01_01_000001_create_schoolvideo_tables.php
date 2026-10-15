<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->timestamps();
        });

        // 2. Profiles
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->timestamps();
        });

        // 3. Majors (Jurusan)
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->default('code');
            $table->timestamps();
        });

        // 4. Classes (Kelas)
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->nullable()->constrained('majors')->onDelete('set null');
            $table->string('name');
            $table->string('grade_level'); // X, XI, XII
            $table->timestamps();
        });

        // 5. Students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->foreignId('major_id')->nullable()->constrained('majors')->onDelete('set null');
            $table->string('nisn')->nullable();
            $table->timestamps();
        });

        // 6. Teachers
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nip')->nullable();
            $table->string('subject')->nullable();
            $table->timestamps();
        });

        // 7. Parents
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');
            $table->string('occupation')->nullable();
            $table->timestamps();
        });

        // 8. Alumni
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('graduation_year')->nullable();
            $table->string('current_profession')->nullable();
            $table->string('company')->nullable();
            $table->timestamps();
        });

        // 9. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->default('video');
            $table->timestamps();
        });

        // 10. Videos
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_url');
            $table->string('thumbnail_url')->nullable();
            $table->integer('duration')->default(30); // in seconds
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->boolean('is_short')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        // 11. Comments
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        // 12. Likes
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->unique(['user_id', 'video_id']);
            $table->timestamps();
        });

        // 13. Shares
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->string('platform')->default('link');
            $table->timestamps();
        });

        // 14. Hashtags
        Schema::create('hashtags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // without #
            $table->integer('posts_count')->default(0);
            $table->timestamps();
        });

        // 15. Video Hashtags
        Schema::create('video_hashtags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->foreignId('hashtag_id')->constrained()->onDelete('cascade');
            $table->unique(['video_id', 'hashtag_id']);
            $table->timestamps();
        });

        // 16. Followers
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');
            $table->unique(['follower_id', 'followed_id']);
            $table->timestamps();
        });

        // 17. Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('type'); // like, comment, follow, system
            $table->text('message');
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // 18. User Interactions
        Schema::create('user_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->integer('watch_time_seconds')->default(0);
            $table->boolean('completed_watch')->default(false);
            $table->string('interaction_type')->default('view'); // view, like, comment, share
            $table->timestamps();
        });

        // 19. School Profile
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('npsn');
            $table->text('vision');
            $table->text('mission');
            $table->text('structure');
            $table->json('facilities')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();
        });

        // 20. Test Cases (Bab 14)
        Schema::create('test_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number');
            $table->string('feature');
            $table->text('scenario');
            $table->text('expected_result');
            $table->string('status')->default('PASSED'); // PASSED, FAILED, PENDING
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_cases');
        Schema::dropIfExists('school_profiles');
        Schema::dropIfExists('user_interactions');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('followers');
        Schema::dropIfExists('video_hashtags');
        Schema::dropIfExists('hashtags');
        Schema::dropIfExists('shares');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('alumni');
        Schema::dropIfExists('parents');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('students');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('majors');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('roles');
    }
};
