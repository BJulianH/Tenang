<?php
// database/migrations/xxxx_xx_xx_create_tasks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            
            // Priority and Status
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
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
            $table->enum('status', [
                'pending', 
                'in_progress', 
                'completed', 
                'cancelled', 
                'snoozed'
            ])->default('pending');
            
            // Date and Time
            $table->date('due_date')->nullable();
            $table->time('due_time')->nullable();
            $table->integer('reminder_before')->nullable()->comment('Minutes before due time');
            
            // Recurring tasks
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_pattern', [
                'daily', 
                'weekly', 
                'monthly', 
                'weekdays',
                'weekends',
                'custom'
            ])->nullable();
            $table->json('recurring_days')->nullable()->comment('[1,3,5] for days of week');
            $table->date('recurring_end_date')->nullable();
            
            // Task characteristics
            $table->integer('estimated_duration')->nullable()->comment('In minutes');
            $table->tinyInteger('energy_level_required')->nullable()->comment('1-5 scale');
            $table->tinyInteger('difficulty_level')->nullable()->comment('1-5 scale');
            
            // Eisenhower Matrix
            $table->boolean('is_important')->default(false);
            $table->boolean('is_urgent')->default(false);
            
            // Completion tracking
            $table->timestamp('completed_at')->nullable();
            $table->tinyInteger('mood_before')->nullable()->comment('1-5 scale, mood before task');
            $table->tinyInteger('mood_after')->nullable()->comment('1-5 scale, mood after task');
            $table->text('notes')->nullable()->comment('User notes after completion');
            
            // Tags and metadata
            $table->json('tags')->nullable();
            $table->integer('streak_count')->default(0)->comment('For recurring tasks');
            $table->integer('completion_count')->default(0);
            
            // Soft deletes and timestamps
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'due_date']);
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'priority']);
            $table->index(['user_id', 'is_important', 'is_urgent']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};