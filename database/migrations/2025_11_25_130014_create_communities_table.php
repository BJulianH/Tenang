<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesTable extends Migration
{
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('profile_image')->nullable();
            $table->enum('type', ['public', 'private', 'restricted'])->default('public');
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('parent_id')->nullable()->constrained('communities')->onDelete('cascade');
            $table->boolean('is_main')->default(false); // Untuk komunitas utama
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('communities');
    }
}