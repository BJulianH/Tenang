<?php
// database/migrations/2024_01_01_000005_create_votes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('voteable');
            $table->enum('type', ['upvote', 'downvote']);
            $table->timestamps();
            
            $table->unique(['user_id', 'voteable_id', 'voteable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}