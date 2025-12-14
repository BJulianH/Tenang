<?php
// database/migrations/xxxx_xx_xx_create_task_templates_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', [
                'self_care', 
                'therapy', 
                'medication', 
                'exercise', 
                'social', 
                'work',
                'appointment',
                'mindfulness',
                'creative',
                'chores',
                'other'
            ])->default('other');
            $table->integer('estimated_duration')->nullable();
            $table->tinyInteger('energy_level_required')->nullable();
            $table->tinyInteger('difficulty_level')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_public')->default(false);
            $table->integer('usage_count')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'is_public']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_templates');
    }
};