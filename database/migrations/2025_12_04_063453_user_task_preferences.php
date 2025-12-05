<?php
// database/migrations/xxxx_xx_xx_create_user_task_preferences_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_task_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Notification preferences
            $table->boolean('enable_reminders')->default(true);
            $table->boolean('enable_due_date_reminders')->default(true);
            $table->integer('default_reminder_before')->default(30)->comment('Minutes');
            
            // Display preferences
            $table->boolean('show_completed_tasks')->default(true);
            $table->boolean('group_by_category')->default(true);
            $table->enum('default_view', ['list', 'calendar', 'matrix'])->default('list');
            
            // Task defaults
            $table->string('default_category')->default('other');
            $table->enum('default_priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            
            // Energy tracking
            $table->boolean('track_energy_levels')->default(true);
            $table->boolean('track_mood_changes')->default(true);
            
            // Achievement settings
            $table->boolean('enable_achievements')->default(true);
            $table->boolean('show_progress_bars')->default(true);
            
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_task_preferences');
    }
};