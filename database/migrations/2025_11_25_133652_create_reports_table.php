<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->morphs('reportable'); // reportable_id, reportable_type (Post, Comment, User, dll)
            $table->text('reason');
            $table->text('additional_info')->nullable();
            $table->enum('status', ['pending', 'resolved', 'dismissed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('resolved_at')->nullable();
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->json('evidence')->nullable(); // Screenshot atau bukti lainnya
            $table->timestamps();
            $table->softDeletes();
            // Index untuk performa
            // $table->index(['reportable_type', 'reportable_id']);
            $table->index('status');
            $table->index('severity');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};