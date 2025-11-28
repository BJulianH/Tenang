<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_quests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['app_activity', 'daily_life', 'mental_health']);
            $table->enum('category', [
                'journaling',
                'mood_tracking',
                'community',
                'self_care',
                'productivity',
                'mindfulness',
                'physical_health',
                'digital_wellbeing'
            ]);
            $table->integer('points')->default(10);
            $table->integer('coins')->default(5);
            $table->integer('diamonds')->default(1);
            $table->integer('max_completions')->default(1);
            $table->integer('required_progress')->default(1);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_repeatable')->default(false);
            $table->json('requirements')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_quests');
    }
};