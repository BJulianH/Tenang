<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->date('birthdate')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('birthdate');
            $table->integer('streak')->default(0)->after('avatar');
            $table->integer('coins')->default(0)->after('streak');
            $table->integer('diamonds')->default(0)->after('coins');
            $table->integer('level')->default(1)->after('diamonds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'birthdate', 
                'bio',
                'avatar',
                'streak',
                'coins',
                'diamonds',
                'level'
            ]);
        });
    }
};