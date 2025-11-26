<?php
// database/migrations/2024_01_01_000003_create_posts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('community_id')->constrained()->onDelete('cascade');
            
            // Tambahkan field baru untuk mental health
            $table->enum('mood', ['happy', 'calm', 'anxious', 'sad', 'angry', 'neutral'])->default('neutral');
            $table->boolean('is_anonymous')->default(false);
            $table->enum('content_type', ['text', 'image', 'video', 'achievement'])->default('text');
            $table->boolean('is_support_request')->default(false);
            $table->json('tags')->nullable();
            
            // Stats
            $table->integer('upvotes_count')->default(0);
            $table->integer('downvotes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('saves_count')->default(0);
            $table->integer('share_count')->default(0);
            $table->integer('view_count')->default(0);
            
            // Moderation
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['community_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['mood', 'created_at']);
            $table->index(['is_support_request', 'created_at']);
            $table->index(['is_featured', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}