<?php
// database/migrations/xxxx_xx_xx_add_task_stats_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Stats untuk tasks
            $table->integer('tasks_completed')->default(0)->after('quests_completed');
            $table->integer('tasks_streak')->default(0)->after('tasks_completed');
            $table->integer('tasks_created')->default(0)->after('tasks_streak');
            $table->date('last_task_completed_at')->nullable()->after('tasks_created');
            $table->decimal('task_completion_rate', 5, 2)->default(0)->after('last_task_completed_at');
            
            // Preferences untuk tasks (bisa dipindah ke tabel terpisah)
            $table->json('task_preferences')->nullable()->after('notification_settings');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tasks_completed',
                'tasks_streak',
                'tasks_created',
                'last_task_completed_at',
                'task_completion_rate',
                'task_preferences'
            ]);
        });
    }
};