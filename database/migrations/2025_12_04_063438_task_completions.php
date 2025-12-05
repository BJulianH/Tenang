<?php
// database/migrations/xxxx_xx_xx_create_task_completions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('completed_at');
            $table->tinyInteger('mood_before')->nullable();
            $table->tinyInteger('mood_after')->nullable();
            $table->integer('actual_duration')->nullable()->comment('In minutes');
            $table->text('notes')->nullable();
            $table->integer('points_earned')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'completed_at']);
            $table->index('task_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_completions');
    }
};