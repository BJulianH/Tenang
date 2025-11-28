<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_quests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('daily_quest_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['assigned', 'in_progress', 'completed', 'claimed'])->default('assigned');
            $table->integer('progress')->default(0);
            $table->integer('required_progress')->default(1);
            $table->date('assigned_date');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('claimed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'daily_quest_id', 'assigned_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_quests');
    }
};