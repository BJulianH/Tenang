<?php
// database/migrations/xxxx_xx_xx_create_task_reminders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->timestamp('reminder_time');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->string('channel')->default('push')->comment('push, email, sms');
            $table->text('message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            
            $table->index(['reminder_time', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_reminders');
    }
};