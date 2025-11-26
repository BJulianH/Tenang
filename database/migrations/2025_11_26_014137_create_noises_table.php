<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('noise_type_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable(); // Deskripsi spesifik
            $table->string('audio_file')->nullable(); // File audio
            $table->integer('duration')->default(0); // Durasi dalam detik
            $table->boolean('is_loop')->default(true); // Bisa di-loop
            $table->boolean('is_premium')->default(false); // Premium atau gratis
            $table->integer('play_count')->default(0); // Jumlah diputar
            $table->float('volume_level')->default(0.7); // Level volume default
            $table->json('tags')->nullable(); // Tag untuk pencarian
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noises');
    }
};