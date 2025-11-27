<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('use_cases', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tidur, Fokus, Relaksasi, dll
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // Icon representasi
            $table->text('description')->nullable(); // Icon representasi
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('use_cases');
    }
};