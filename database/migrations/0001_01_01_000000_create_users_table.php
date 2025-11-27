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

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Profile Information
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            
            // Social Media Links
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            
            // Personal Information
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            
            // Account Settings
            $table->enum('role', ['user', 'moderator', 'admin'])->default('user');
            $table->enum('account_type', ['personal', 'business', 'creator'])->default('personal');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_online')->default(false);
            
            // Privacy Settings
            $table->boolean('show_email')->default(false);
            $table->boolean('show_date_of_birth')->default(false);
            $table->enum('profile_visibility', ['public', 'private', 'friends_only'])->default('public');
            
            // Statistics
            $table->integer('reputation_score')->default(0);
            $table->integer('post_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('follower_count')->default(0);
            $table->integer('following_count')->default(0);
            
            // Preferences
            $table->string('timezone')->default('UTC');
            $table->string('locale', 10)->default('id');
            $table->json('notification_settings')->nullable();
            $table->json('preferences')->nullable();
            
            // Timestamps
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['username', 'is_active']);
            $table->index(['email_verified_at', 'is_active']);
            $table->index('last_login_at');
        });
    


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
